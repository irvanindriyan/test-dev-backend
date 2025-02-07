<?php

namespace App\Helpers;

class FunctionHelpers
{
	public static function responResult($data, $code) 
    {
        $result['code'] = $code;

        switch ($code) {
        	case '200':
        			$status = 'success';
        		break;

        	case '500':
        			$status = 'errors';
        		break;
        	
        	default:
        			$status = 'warnings';
        		break;
        }
        
        $result['status'] = $status;

        if (is_array($data)) {
            $result['data'] = $data;
        } else if (is_object($data)) {
            $result['data'] = $data;
        } else if (!empty($data) && $data != 0) {
            $result['message'] = $data;
        }

        return $result;
    }

    public static function resSuccess($data) 
    {
        return self::responResult($data, 200);
    }

    public static function resError($data, $code = 500) 
    {
        return self::responResult($data, $code);
    }

    public static function resErrorsValidation($data) 
    {
        $arrError = $data->errors();

        $i = 0;

        foreach ($arrError as $key => $value) {
            if (empty($i)) {
                $message = $arrError[$key];
            }

            $i++;
        }

        return self::resError($message[0], $data->status);
    }
}