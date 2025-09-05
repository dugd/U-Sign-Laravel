set -e

role=${CONTAINER_ROLE:-fpm}

if [ "$role" = "fpm" ]; then

    exec php-fpm

else
    echo "Could not match the container role \"$role\""
    exit 1
fi