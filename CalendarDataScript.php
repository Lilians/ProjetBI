<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 23/10/2016
 * Time: 16:35
 */
include_once './Services/ICSParser.php';
include_once './Model/Event.php';
include_once './DAO/DAO.php';

// URL récupérant les données calendaires relatives au calendrier des vacances scolaires de la zone A
const YEAR_START = 2015;
const YEAR_END = 2018;
const MOZ_URL = 'https://www.mozilla.org/media/caldata/FrenchHolidays.ics';
const URL = "http://www.education.gouv.fr/download.php?file=http://cache.media.education.gouv.fr/ics/Calendrier_Scolaire_Zone_A.ics";
$EVENTS = [];
$DAO = new \DAO\DAO();

function parseDate($date)
{
    return date_create_from_format("Ymd", $date);
}


function treatRegularEvent($event, $key_to_name)
{
    $dtstart = parseDate($event['DTSTART']);
    $dtend = array_key_exists('DTEND', $event) ? parseDate($event['DTEND']) : $dtstart;

    if ($dtstart->getTimestamp() > strtotime(YEAR_START . '-01-01') && $dtend->getTimestamp() < strtotime(YEAR_END . '-12-31')) {
        $myEvent = new \Model\Event();
        $myEvent->setDateStart($dtstart);
        $myEvent->setDateEnd($dtend);
        $myEvent->setName($event[$key_to_name]);
        $myEvent->setCategory(array_key_exists('CATEGORIES', $event) ? $event['CATEGORIES'] : 'Vacances scolaires');
        return $myEvent;
    }
    return null;
}


function getCalendarData($url, $key_to_name)
{
    $events = [];
    $ics = new ICal($url);

    foreach ($ics->cal['VEVENT'] as $event) {
        if (array_key_exists('RRULE', $event) && $event['RRULE'] == "FREQ=YEARLY") {
            for ($i = YEAR_START; $i <= YEAR_END; $i++) {
                $nextDate = parseDate($event['DTSTART']);
                $nextDate->add(new DateInterval("P1Y"));
                $event['DTSTART'] = date_format($nextDate, "Ymd");

                $myEvent = treatRegularEvent($event, $key_to_name);
                if ($myEvent != null)
                    $events[date_format($myEvent->getDateStart(), 'Y_m') . '-' . $myEvent->getName()] = $myEvent;
            }
        } else {
            $myEvent = treatRegularEvent($event, $key_to_name);
            if ($myEvent != null)
                $events[date_format($myEvent->getDateStart(), 'Y_m') . '-' . $myEvent->getName()] = $myEvent;
        }
    }
    return $events;
}


function getSchoolHolidayData()
{
    return getCalendarData(URL, "DESCRIPTION");
}

function getPublicHolidaysData()
{
    return getCalendarData(MOZ_URL, "SUMMARY");
}

$EVENTS = array_merge(getSchoolHolidayData(), getPublicHolidaysData());

$DAO->insertEvents($EVENTS);