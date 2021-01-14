<?php

namespace Spatie\WordPressRay\Spatie\Ray\Payloads;

class FileContentsPayload extends Payload
{
    protected string $file;

    public function __construct(string $file)
    {
        $this->file = $file;
    }

    public function getType(): string
    {
        return 'custom';
    }

    public function getContent(): array
    {
        if (! file_exists($this->file)) {
            return [
                'content' => "File not found: '{$this->file}'",
                'label' => 'File',
            ];
        }

        $contents = file_get_contents($this->file);

        return [
            'content' => $this->encodeContent($contents),
            'label' => basename($this->file),
        ];
    }

    protected function encodeContent(string $content): string
    {
        $result = htmlentities($content);

        // using nl2br() causes tests to fail on windows, so use <br> only
        return str_replace(PHP_EOL, '<br />', $result);
    }
}
