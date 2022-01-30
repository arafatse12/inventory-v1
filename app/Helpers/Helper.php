<?php

use App\Models\Configuration;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

if (!function_exists('app_name')) {
    function app_name()
    {
        $app_name = env('APP_NAME') ? env('APP_NAME') : 'Inventory';
        return $app_name;
    }
}

if (!function_exists('assets')) {
    function assets($filepath = '')
    {
        $env_path = env('PUBLIC_PATH');
        return "$env_path/$filepath";
    }
}

if (!function_exists('can')) {
    function can($permissionName)
    {
        $user_permissons = @unserialize(Session::get('z'));
        if (is_array($permissionName)) {
            foreach ($permissionName as $permission) {
                if (is_array($user_permissons) && in_array($permission, $user_permissons)) {
                    return true;
                }
            }
        } else {
            if (is_array($user_permissons) && in_array($permissionName, $user_permissons)) {
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('returnData')) {
    function returnData($status_code = 2000, $result = null, $message = null)
    {
        $data = [];
        if ($status_code) {
            $data['status'] = $status_code;
        }
        if ($result) {
            $data['result'] = $result;
        }
        if ($message) {
            $data['message'] = $message;
        }
        return $data;
    }
}

if (!function_exists('permissions')) {
    function permissions()
    {
        $user_permissons = @unserialize(Session::get(''));
        if (is_array($user_permissons)) {
            return $user_permissons;
        }
        return [];
    }
}

if (!function_exists('val')) {
    function val($data, $index)
    {
        if (isset($data[$index]) && !is_null($data[$index]) && $data[$index] > 0) {
            return $data[$index];
        }
        return null;
    }
}

if (!function_exists('randomString')) {
    function randomString($length = 25)
    {
        $characters = '123456789abcdefghijklmnopqrstwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $string = (string)time();
        return $randomString . 'time' . $string;
    }
}

if (!function_exists('folder')) {
    function folder($path, $permission = 0777)
    {
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
            return $path;
        } else {
            return $path;
        }
    }
}

if (!function_exists('appFile')) {
    function appFile($path)
    {
        if (file_exists(public_path() . $path)) {
            return $path;
        } else {
            return '/img/no-image.png';
        }
    }
}

if (!function_exists('uploadFile')) {
    function uploadFile($requestFile, $fileName = null, $folder = null)
    {
        try {
            if ($requestFile) {
                $filePath = $folder ? $folder : 'img/';
                $image = $requestFile;
                $format =  explode('/', mime_content_type($requestFile))[1];
                $data['image'] = $fileName ? $fileName . ".$format" : time() . ".$format";
                $img = Image::make($image);
                $upload_path = folder(public_path($filePath));
                $image_url = $upload_path . $data['image'];
                $img->save($image_url);

                if ($img) {
                    return $filePath . $data['image'];
                }
                return null;
            }
        } catch (\Exception $exception) {
            return null;
        }
    }
}

if (!function_exists('ddA')) {
    function ddA($arrayOrObject)
    {
        dd(collect($arrayOrObject)->toArray());
    }
}

if (!function_exists('exact_permission')) {
    function exact_permission($permission_name)
    {
        $explode = explode('_', $permission_name);
        return end($explode);
    }
}


if (!function_exists('sortBy')) {
    function sortBy($request, $default = 'id', $dafaultSort = 'desc')
    {
        if ($request->sort_column && $request->sort) {
            return (object)[
                'column' => $request->sort_column,
                'sort' => $request->sort
            ];
        } else {
            return (object)[
                'column' => $default,
                'sort' => $dafaultSort
            ];
        }
    }
}

if (!function_exists('cacheClear')) {
    function cacheClear(array $caches)
    {
        foreach ($caches as $cache) {
            Cache::forget($cache);
        }
    }
}
