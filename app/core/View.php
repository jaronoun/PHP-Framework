<?php

namespace Isoros\core;

use Exception;

class View
{
    protected $view;
    protected $data = [];

    private $templateDir;

    public function __construct($templateDir) {
        $this->templateDir = $templateDir;
    }

//    public function render($view): void
//    {
//        // Set the page title
//
//        //extract($this->data);
//        $data = ['title' => "", 'loggedIn' => false, 'page' => ""];
//        extract($data);
//        ob_start();
//
//        include __DIR__ . '/../views/layout/header.php';
//        include __DIR__ . "/../views/{$view}.php";
//        include __DIR__ . '/../views/layout/footer.php';
//
//        echo ob_get_clean();
//
//    }

    public function render($templateName, $data) {
        $templatePath = $this->templateDir . '/' . $templateName;
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

//    public function renderParams($view, $data = [])
//    {
//        extract($data);
//
//        ob_start();
//
//        $title = "Home";
//
//        include __DIR__ . '/../views/layout/header.php';
//        include __DIR__ . "/../views/{$view}.php";
//        include __DIR__ . '/../views/layout/footer.php';
//
//        echo ob_get_clean();
//    }

    private function compileTemplate($templateContent, $data) {
        // Implement your template compilation logic here
        // This could involve parsing placeholders, loops, conditionals, etc.
        // and generating the corresponding PHP code

        // For simplicity, let's assume we have variable placeholders {{ }},
        // loop blocks {% %}, conditional blocks {% if %} {% else %} {% endif %},
        // template inheritance {% extends %}, and comments {# #}

        // Remove comments
        $templateContent = preg_replace('/{#\s*(.*?)\s*#}/s', '', $templateContent);

        // Template inheritance
        $templateContent = preg_replace_callback('/{%\s*extends\s+(.*?)\s*%}/', function ($matches) use ($templateContent) {
            $parentTemplate = $matches[1];
            // Load the parent template and replace the content within the blocks
            // based on the child template's content
            $parentContent = file_get_contents($this->templateDir . '/' . $parentTemplate);
            $childContent = preg_replace('/{%\s*block\s+(.*?)\s*%}(.*?)\s*{%\s*endblock\s*%}/s', '<?php $1; ?>$2<?php end$1; ?>', $templateContent);
            return str_replace('{% block content %}', $childContent, $parentContent);
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

        // Conditional blocks
        $templateContent = preg_replace_callback('/{%\s*if\s+(.*?)\s*%}(.*?){%((?:\s*else\s*.*?)?)endif\s*%}/s', function ($matches) use ($data) {
            $condition = $matches[1];
            $ifContent = $matches[2];
            $elseContent = $matches[3];

            $output = '';
            if (eval("return $condition;")) {
                $output = $this->compileTemplate($ifContent, $data);
            } elseif (!empty($elseContent)) {
                $output = $this->compileTemplate($elseContent, $data);
            }

            return $output;
        }, $templateContent);

        return $templateContent;
    }


}

