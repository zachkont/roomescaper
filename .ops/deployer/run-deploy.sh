#!/bin/sh
#
# Author: Nikolaos Stamatopoulos
# Purpose: Runner script for Deployer
# Triggered: By a pipeline step

set -ex

# set some constants
WORKDIR='./ops/deployer'

# deployer workdir
cd ${WORKDIR}

# execute deploy task
dep -vvv deploy $1
