<?php
/**
 * Author: Nikolaos Stamatopoulos
 * Purpose: Deployer script. Contains specific instructions to deploy a prebuilt tarball.
 */

namespace Deployer;

require 'recipe/common.php';

inventory('hosts.yml');

/**
 * Custom configuration parameters
 */
set('tarball_name', 'roomescaper-'. getenv('BUILDKITE_BUILD_NUMBER') .'.release.tar.gz');
set('release_name', getenv('BUILDKITE_BUILD_NUMBER'));

/**
 * Deployer Configuration
 */
set('ssh_multiplexing', false);
set('default_stage', 'staging');
set('keep_releases', 5);
set('shared_dirs', [
    'backup',
    'cache',
    'images',
    'user/accounts',
    'user/config',
    'user/data',
]);
set('shared_files', [
    '.htaccess',
    'BingSiteAuth.xml',
    'icon.png',
    'legal.gif',
    'robots.txt'
]);
set('writable_dirs', [
    'assets',
    'backup',
    'cache',
    'images',
    'logs',
    'tmp',
    'user/accounts',
    'user/config',
    'user/data',
]);
set('clear_paths', [
    get('tarball_name')
]);
set('allow_anonymous_stats', false);

/**
 * Tasks
 */
desc('Uploads tar to release_path and extracts it');
task('roomesc_upload_extract', function () {
    writeln('Uploading tarball...');
    upload('./{{tarball_name}}', '{{release_path}}/{{tarball_name}}');

    writeln('Extracting tarball...');
    run('tar --warning=no-timestamp -xzf {{release_path}}/{{tarball_name}} -C {{release_path}}');
});

desc('Deploys project');
task('deploy', [
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'roomesc_upload_extract',
    'deploy:shared',
    'deploy:writable',
    'deploy:clear_paths',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
    'success'
]);
after('deploy:failed', 'deploy:unlock');
