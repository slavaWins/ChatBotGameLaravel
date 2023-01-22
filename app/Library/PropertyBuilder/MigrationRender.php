<?php

namespace App\Library\PropertyBuilder;

use App\Models\PropertyBuilder\PropertyBuilderModel;
use App\Models\User;

class MigrationRender
{

    public static function GetType($type)
    {
        if ($type == "int") return "integer";
        if ($type == "string") return 'string';
        if ($type == "select") return 'string';
        if ($type == "checkbox") return 'boolean';
        return 'string';
    }

    public static function RenderDoc(PropertyBuilderModel $model)
    {
        $list = [];
        $inputs = $model->GetPropertys();

        foreach ($inputs as $ind => $prop) {
            $data = [];

            $data[self::GetType($prop->typeData)] = $ind;

            if ($prop->default) $data['default'] = $prop->default;

            if (!$prop->default) $data['nullable'] = null;
            if ($prop->comment || $prop->descr) $data['comment'] = $prop->comment ?? $prop->descr;


            foreach ($data as $K => $V) {

                if (is_string($V)) $V = '"' . $V . '"';
                if (is_null($V)) $V = '';

                if ($prop->typeData == "checkbox" and $K == "default") {
                    if ($V) {
                        $V = "true";
                    } else {
                        $V = "false";
                    }
                }
                $data[$K] = $V;
            }
            $list[$ind] = $data;
        }

        $view = view("property-builder.migration", ['list' => $list]);
        $view = nl2br($view);
        return $view . ' ';
    }

    public static function RenderMigration(PropertyBuilderModel $model)
    {
        $list = [];
        $inputs = $model->GetPropertys();

        foreach ($inputs as $ind => $prop) {
            $data = [];

            $data[self::GetType($prop->typeData)] = $ind;

            if ($prop->default) $data['default'] = $prop->default;

            if (!$prop->default) $data['nullable'] = null;
            if ($prop->comment || $prop->descr) $data['comment'] = $prop->comment ?? $prop->descr;


            foreach ($data as $K => $V) {

                if (is_string($V)) $V = '"' . $V . '"';
                if (is_null($V)) $V = '';

                if ($prop->typeData == "checkbox" and $K == "default") {
                    if ($V) {
                        $V = "true";
                    } else {
                        $V = "false";
                    }
                }
                $data[$K] = $V;
            }
            $list[$ind] = $data;
        }

        $view = view("property-builder.migration", ['list' => $list]);
        $view = nl2br($view);
        return $view . ' ';
    }

}
