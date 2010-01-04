<?php

$spec = Pearfarm_PackageSpec::create(array(Pearfarm_PackageSpec::OPT_BASEDIR => dirname(__FILE__)))
             ->setName('plow')
             ->setChannel('jetviper21.pearfarm.org')
             ->setSummary('A Simple Rake Like task runner for php')
             ->setDescription('Using a simple command interface create tasks to run with dependencies')
             ->setReleaseVersion('0.1.0')
             ->setReleaseStability('beta')
             ->setApiVersion('0.1.0')
             ->setApiStability('beta')
             ->setLicense(Pearfarm_PackageSpec::LICENSE_MIT)
             ->setNotes('Beta release.')
             ->addMaintainer('lead', 'Scott Davis', 'jetviper21', 'jetviper21@gmail.com')
             ->addGitFiles()
             ->addExecutable('bin/plow')
             ;