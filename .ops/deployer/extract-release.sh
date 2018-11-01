#!/bin/sh
#
# Author: Nikolaos Stamatopoulos
# Purpose: Runner script for Deployer
# Triggered: By a pipeline step

set -ex

# set some constants
IMAGE="roomescaper:${BUILDKITE_BUILD_NUMBER}"
CONTAINER='tmp-container'
TARBALL_NAME="roomescaper-${BUILDKITE_BUILD_NUMBER}.release.tar.gz"
WORKDIR='./ops/deployer'

# deployer workdir
cd ${WORKDIR}

# safety action to remove container from previously interrupted deployment
docker rm --force ${CONTAINER} || true

# create an idle container off of the built image
docker run -d --name ${CONTAINER} ${IMAGE} tail -f /dev/null

# copy tar from container into current folder
docker cp ${CONTAINER}:/tmp/${TARBALL_NAME} ./${TARBALL_NAME}

# remove container from agent
docker rm --force ${CONTAINER}

# upload as artifact
buildkite-agent artifact upload ${TARBALL_NAME}
