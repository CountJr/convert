<?php
namespace Encoder;

return function ($json) {
        return yaml_emit(json_decode($json, TRUE), YAML_UTF8_ENCODING);
};

