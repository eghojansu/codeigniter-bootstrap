<?php

/**
 * Generate TWBS alert component
 *
 * @param  string $message
 * @param  string $type
 * @return string|null
 */
function alert($message, $type = 'danger') {
    if ($message) {
        return '<div class="alert alert-'.$type.'">'.
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.
            '<strong>Error!</strong> '.$message.
            '</div>';
    }

    return null;
}

/**
 * Validate unique value
 *
 * @param  mixed $value
 * @param  string $args table,column,id
 * @return boolean
 */
function validateUnique($value, $args) {
    $args = explode(',', $args) + [2=>null];

    $row = get_instance()->db->where($args[1], $value)->get($args[0], 1)->row();

    return (!$row || ($args[2] || $row->id == $args[2]));
}

/**
 * Validate record existance
 *
 * @param  mixed $value
 * @param  string $args table,column
 * @return boolean
 */
function validateExists($value, $args) {
    $args = explode(',', $args);

    $row = get_instance()->db->where($args[1], $value)->get($args[0], 1)->row();

    return !empty($row);
}

/**
 * Validate password value
 *
 * @param  mixed $value
 * @param  string $hash Hashed password
 * @return boolean
 */
function validatePassword($password, $hash) {
    return Bcrypt::create()->verify($password, $hash);
}

/**
 * Validate time value
 *
 * @param  mixed $value
 * @return boolean
 */
function validateTime($value) {
    try {
        new DateTime($value);

        return true;
    } catch (Exception $e) {
        return false;
    }
}

/**
 * Convert number to angka (indonesian)
 *
 * @param  number $angka
 * @return string
 */
function angka($angka) {
    return number_format($angka, 0, ',', '.');
}

/**
 * Convert date from sql
 *
 * @param  string $time
 * @param  string $format
 * @return string|false
 */
function tanggalSql($time, $format = 'd-m-Y') {
    try {
        $dateTime = new DateTime($time);

        return $dateTime->format($format);
    } catch (Exception $e) {
        return false;
    }
}

/**
 * Convert date from indonesian date
 *
 * @param  string $time
 * @param  string $format
 * @return string|false
 */
function tanggalIndo($time, $format = 'Y-m-d') {
    $temp = explode('-', $time);
    krsort($temp);
    $converted = implode('-', $temp);

    try {
        $dateTime = new DateTime($converted);

        return $dateTime->format($format);
    } catch (Exception $e) {
        return false;
    }
}

/**
 * Generate datetime
 *
 * @param  mixed $time
 * @param  string $format
 * @return DateTime|string|null
 */
function createDateTime($time = null, $format = 'd-m-Y') {
    try {
        $datetime = new DateTime($time);

        if ($format) {
            return $datetime->format($format);
        }

        return $datetime;
    } catch (Exception $e) {
        return null;
    }
}

/**
 * Get month name in indonesian by index
 *
 * @param  int $no
 * @return string|null
 */
function bulan($no = null) {
    $no = 1*($no?:date('m'));
    $bulan = get_instance()->config->item('app_bulan');

    return array_key_exists($no, $bulan)?$bulan[$no]:null;
}

/**
 * Fix path slashes
 *
 * @param  string  $path
 * @param  boolean $suffix
 * @return string
 */
function fixslashes($path, $suffix = true) {
    return rtrim(strtr($path, '\\', '/'), '/').($suffix?'/':'');
}

/**
 * Handle file upload
 *
 * @param  string $key
 * @param  string &$filename
 * @param  array  $allowedTypes
 * @return string|false
 */
function handleFileUpload($key, &$filename, $allowedTypes = []) {
    $result = false;
    $isArray = isset($_FILES[$key]) && is_array($_FILES[$key]['error']);
    $filename = fixslashes($filename, false);

    if ($isArray) {
        return $result;
    }

    if (isset($_FILES[$key]) &&
        UPLOAD_ERR_OK === $_FILES[$key]['error'] &&
        ($allowedTypes && in_array($_FILES[$key]['type'], $allowedTypes))) {
        if ('/' === substr($filename, -1)) {
            $filename .= $_FILES[$key]['name'];
        }
        else {
            $ext = strtolower(strrchr($_FILES[$key]['name'], '.'));
            $filename .= $ext;
        }
        $result = move_uploaded_file($_FILES[$key]['tmp_name'], $filename);
    }

    return $result;
}

/**
 * Handle image upload
 *
 * @param  string $key
 * @param  string &$filename
 * @return string|false
 */
function handleImageUpload($key, &$filename) {
    $allowedTypes = ['image/jpg','image/png','image/jpeg'];

    return handleFileUpload($key, $filename, $allowedTypes);
}
