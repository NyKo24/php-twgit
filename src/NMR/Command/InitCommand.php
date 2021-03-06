<?php

namespace NMR\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class InitCommand
 */
class InitCommand extends AbstractCommand
{
    /**
     * {inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('init')
            ->setDescription('Initialize git repository for twgit')
            ->addArgument('command', InputArgument::REQUIRED, 'Command')
            ->addArgument('tagname', InputArgument::REQUIRED, 'TagName')
            ->addArgument('remoteUrl', InputArgument::OPTIONAL, 'remoteUrl')
            ->addOption('silent', 's', InputOption::VALUE_NONE, 'Disable interactive mode');
    }

    /**
     * {inheritdoc}
     */
    public function needGitRepository()
    {
        return false;
    }

    /**
     * {inheritdoc}
     */
    public function needTwgitRepository()
    {
        return false;
    }

    /**
     * {inheritdoc}
     */
    public function showUsage()
    {
        $prefixTag = $this->getConfig()->get('twgit.workflow.prefixes.tag');
        $origin = $this->getConfig()->get('twgit.git.origin');
        $stable = $this->getConfig()->get('twgit.git.stable');

        $this->getLogger()->writeln(
            <<<EOT
<cb>(i)</> <c>Usage</>
<wb>    twgit init <tagname> [<url>]</>

                    Initialize git repository for twgit:
                      – git init if necessary
                      – add remote origin <url> if necessary
                      – create 'stable' branch if not exists, or pull '{$origin}/{$stable}'
                        branch if exists
                      – create <tagname> tag on HEAD of stable, e.g. 1.2.3, using
                        major.minor.revision format.
                        Prefix '{$prefixTag}' will be added to the specified <tagname>.
                      A remote repository must exists.
EOT
        );
    }
}