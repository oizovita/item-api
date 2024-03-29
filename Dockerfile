# Use an official PHP runtime as a parent image
FROM php:8.3.4

# Set the working directory in the container to /app
WORKDIR /app

# Copy the current directory contents into the container at /app
COPY . /app


# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install project dependencies
RUN composer install

# Make port 80 available to the world outside this container
EXPOSE 8000

# Start the PHP server
CMD ["php", "-S", "0.0.0.0:8000", "-t", "/app/public"]