<?php
return function (\Evenement\EventEmitterInterface $emitter) {
    // Mocking objects
    new \Peridot\Plugin\Prophecy\ProphecyPlugin($emitter);
    // Watch for code change
    //new \Peridot\Plugin\Watcher\WatcherPlugin($emitter);
    // Auto prophecy mock
    new \Mrkrstphr\Peridot\Plugin\Automock\AutomockPlugin($emitter, true);
    // Fixture
    $emitter->on('peridot.start', function (\Peridot\Console\Environment $environment) {
        // Set default path
        $environment->getDefinition()->getArgument('path')->setDefault('specs');
        // Add code coverage option
        $environment->getDefinition()->option('coverage', 'o', \Symfony\Component\Console\Input\InputOption::VALUE_NONE,
            'Run cloack code coverage report (using cloack.toml file)');
    });
    // Code Coverage
    $emitter->on("peridot.execute", function (\Symfony\Component\Console\Input\InputInterface $input) use (&$emitter) {
        if ($input->getOption('coverage')) {
            \cloak\peridot\CloakPlugin::create('cloak.toml')->registerTo($emitter);
        }
    });
};