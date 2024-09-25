<?php

namespace App\Service;

use App\Entity\Section;
use Symfony\Component\Filesystem\Filesystem;
use Twig\Environment;

class SectionGenerator
{
    private $twig;
    private $projectDir;
    private $filesystem;

    public function __construct(Environment $twig, string $projectDir, Filesystem $filesystem)
    {
        $this->twig = $twig;
        $this->projectDir = $projectDir;
        $this->filesystem = $filesystem;
    }

    public function generate(Section $section): void
    {
        $this->generateHtml($section);
        $this->generateCss($section);
        $this->generateJs($section);
    }

    private function generateHtml(Section $section): void
    {
        $template = $this->twig->load('components/template.html.twig');
        $content = $template->render([
            'section' => $section,
        ]);

        $filePath = sprintf('%s/templates/components/%s/%s.html.twig',
            $this->projectDir,
            $section->getType(),
            $section->getName()
        );

        $this->filesystem->dumpFile($filePath, $content);
    }

    private function generateCss(Section $section): void
    {
        $content = sprintf('/* CSS for %s */', $section->getName());

        $filePath = sprintf('%s/assets/css/%s/%s.css',
            $this->projectDir,
            $section->getType(),
            $section->getName()
        );

        $this->filesystem->dumpFile($filePath, $content);
    }

    private function generateJs(Section $section): void
    {
        $content = sprintf('// JS for %s', $section->getName());

        $filePath = sprintf('%s/assets/js/%s/%s.js',
            $this->projectDir,
            $section->getType(),
            $section->getName()
        );

        $this->filesystem->dumpFile($filePath, $content);
    }
}