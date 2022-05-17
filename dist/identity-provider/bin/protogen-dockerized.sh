#!/bin/bash

cd $(dirname "$0")
workDir=$(pwd)
multiverseDir=/tmp/multiverse
protocImage=namely/protoc-all:1.13
outputDir="$workDir/../grpc"


echo "Cleaning old files..."
rm -rf "$multiverseDir"

echo "Installing multiverse..."
git clone git@github.com:sugarcrm/multiverse.git "$multiverseDir"

echo "Pulling image with protoc and grpc stuff..."
docker pull "$protocImage"

echo "Building PHP GRPC libraries..."
mkdir -p "$outputDir"
cd "$multiverseDir"
find ./apis/iam ./apis/rpc -name "*.proto" -print | while read f; do
    docker run --rm \
    -v `pwd`:/defs \
    -v "$outputDir":/tmp/generated \
    "$protocImage" -f "$f" -o /tmp/generated -l php
done
