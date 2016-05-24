<?php
namespace Converter\Decoders;

return function ($text) {
        return json_encode(yaml_parse($text), JSON_UNESCAPED_UNICODE);
};
