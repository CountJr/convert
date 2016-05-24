<?php
namespace Converter\Encoders;

return function ($json) {
        return yaml_emit(json_decode($json, true), YAML_UTF8_ENCODING);
};
