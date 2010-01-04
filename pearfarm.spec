<?php

$spec = Pearfarm_PackageSpec::create(array(Pearfarm_PackageSpec::OPT_BASEDIR => dirname(__FILE__)))
             ->setName('plow')
             ->setChannel('jetviper21.pearfarm.org')
             ->setSummary('A Simple Rake Like task runner for php')
             ->setDescription('Using a simple command interface create tasks to run with dependencies')
             ->setReleaseVersion('0.0.1')
             ->setReleaseStability('alpha')
             ->setApiVersion('0.0.1')
             ->setApiStability('alpha')
             ->setLicense(Pearfarm_PackageSpec::LICENSE_MIT)
             ->setNotes('Initial release.')
             ->addMaintainer('lead', 'Scott Davis', 'jetviper21', 'jetviper21@gmail.com')
             ->addGitFiles()
             ->addExecutable('bin/plow')
             ;