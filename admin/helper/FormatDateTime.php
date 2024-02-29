<?php 
class FormatDateHelper {
    public static function getDate(string $date) {
        $cr_date=date_create($date);
        return date_format($cr_date,"d/m/Y");
    }
    public static function getDateTime(string $datetime) {
        $cr_datetime=date_create($datetime);
        return date_format($cr_datetime,"H:i:s d/m/Y");
    }
    public static function getDateToInputHtml(string $date) {
        $cr_date=date_create($date);
        return date_format($cr_date,"Y-m-d");
    }
}