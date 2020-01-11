#!/usr/bin/env bash
set -euo pipefail # Fail early

PROJECT_DIRECTORY=$(realpath "$(dirname "$0")/../")

# Create the new local config from the sample one. Use -n for not overwriting
# an existing config.
cp -n "${PROJECT_DIRECTORY}/config/config.local.sample.neon" \
 "${PROJECT_DIRECTORY}/config/config.local.neon"

php "${PROJECT_DIRECTORY}/bin/fill-salts.php"
