#!/bin/sh
#
# Author: Nikolaos Stamatopoulos
# Purpose: To execute the Prettier task
# Triggered: By a pipeline step

set -ex

cd /var/www/html/
yarn prettier-check
