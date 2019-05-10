#!/usr/bin/env bash

echo 'configuring network'

python /etc/powerpi_client/networkConfig.py

echo 'Starting powerpi client scripts'

python /etc/powerpi_client/currentSensor.py &
python /etc/powerpi_client/load_detector.py

