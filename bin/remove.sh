#!/bin/bash

echo "Removing containers, networks, volumes..."
docker compose down -v
