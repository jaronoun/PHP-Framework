<?php

namespace Isoros\core;

use Exception;

class View
{
    protected $view;
    protected array $data = [];

    private $templateDir;

    public function __construct($templateDir) {
        $this->templateDir = $templateDir;
    }

    public function render($templateName, $data): bool|string
    {
        $templatePath = $this->templateDir . '\\' . $templateName;

        if (!file_exists($templatePath)) {
            throw new Exception("Template file not found: " . $templatePath);
        }

        $templateContent = file_get_contents($templatePath);
        $compiledContent = $this->compileTemplate($templateContent, $data);

        // Execute the compiled PHP code
        ob_start();
        eval(' ?>' . $compiledContent . '<?php ');
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }

    private function compileTemplate($templateContent, $data) {
        // Remove comments
        $templateContent = preg_replace('/{#\s*(.*?)\s*#}/s', '', $templateContent);

        // Template inheritance
        $templateContent = preg_replace_callback('/{%\s*extends\s+(.*?)\s*%}/', function ($matches) use ($templateContent, $data) {
            $parentTemplate = $matches[1];
            $parentContent = file_get_contents($this->templateDir . '\\' . $parentTemplate);
            $childContent = str_replace('{% block content %}', $templateContent, $parentContent);
            return $this->compileTemplate($childContent, $data);
        }, $templateContent);

        // Conditional blocks
        $templateContent = preg_replace_callback('/{%\s*if\s+(.*?)\s*%}(.*?)(?:{%\s*else\s*%}(.*?))?{%\s*endif\s*%}/s', function ($matches) use ($data) {
            $condition = $data[$matches[1]];
            $ifContent = $matches[2];
            $elseContent = $matches[3] ?? '';

            $output = '';
            if (eval("return $condition;")) {
                $output = $this->compileTemplate($ifContent, $data);
            } else {
                $output = $this->compileTemplate($elseContent, $data);
            }

            return $output;
        }, $templateContent);

        // Variable placeholders
        $templateContent = preg_replace_callback('/{{\s*([\w\.]+)\s*}}/', function ($matches) use ($data) {
            $variableName = $matches[1];
            return $data[$variableName] ?? '';
        }, $templateContent);

        // Loop blocks
        $templateContent = preg_replace_callback('/{%\s*for\s+(\w+)\s+in\s+([\w\.]+)\s*%}(.*?)\s*{%\s*endfor\s*%}/s', function ($matches) use ($data) {
            $loopVariable = $matches[1];
            $arrayVariable = $matches[2];
            $loopContent = $matches[3];

            $output = '';
            $array = $data[$arrayVariable] ?? [];
            foreach ($array as $item) {
                $data[$loopVariable] = $item;
                $output .= $this->compileTemplate($loopContent, $data);
            }

            return $output;
        }, $templateContent);


        return $templateContent;
    }


}

