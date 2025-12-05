<?php
// lib/Form.php
/**
 * Class Form
 * Library sederhana untuk membangun form input (text, number, textarea, file, date, submit)
 *
 * Contoh penggunaan: di views/user/add.php Anda panggil `new Form(...)` lalu addField dan render
 * Ini diadaptasi dan disempurnakan dari contoh Praktikum 10.
 */
class Form {
    private $action;
    private $method;
    private $fields = [];

    public function __construct($action = '', $method = 'POST') {
        $this->action = $action;
        $this->method = strtoupper($method);
    }

    // tambah field, $type: text|number|textarea|file|date|hidden
    public function addField($name, $label, $type = 'text', $value = '', $attrs = []) {
        $this->fields[] = compact('name', 'label', 'type', 'value', 'attrs');
    }

    // render satu field
    protected function renderField($f) {
        $attrStr = '';
        foreach ($f['attrs'] as $k => $v) {
            $attrStr .= ' ' . htmlspecialchars($k) . '="' . htmlspecialchars($v) . '"';
        }
        $val = htmlspecialchars($f['value']);
        switch ($f['type']) {
            case 'textarea':
                return "<label>{$f['label']}</label><textarea name=\"{$f['name']}\" class=\"form-control\"{$attrStr}>{$val}</textarea>";
            case 'file':
                return "<label>{$f['label']}</label><input type=\"file\" name=\"{$f['name']}\" class=\"form-control\"{$attrStr}>";
            default:
                return "<label>{$f['label']}</label><input type=\"{$f['type']}\" name=\"{$f['name']}\" value=\"{$val}\" class=\"form-control\"{$attrStr}>";
        }
    }

    // tampilkan form
    public function open($extra = '') {
        return "<form action=\"{$this->action}\" method=\"{$this->method}\" {$extra}>";
    }

    public function close() {
        return "</form>";
    }

    public function render($submitLabel = 'Simpan') {
        $html = $this->open();
        foreach ($this->fields as $f) {
            $html .= "<div class=\"mb-3\">" . $this->renderField($f) . "</div>";
        }
        $html .= "<button class=\"btn btn-primary\">".htmlspecialchars($submitLabel)."</button>";
        $html .= $this->close();
        return $html;
    }
}
