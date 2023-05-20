#!/bin/bash

if [[ "$OSTYPE" == "linux-gnu"* ]]; then
    echo "Sistema operativo: Linux"
elif [[ "$OSTYPE" == "darwin"* ]]; then
    echo "Sistema operativo: macOS"
elif [[ "$OSTYPE" == "cygwin" || "$OSTYPE" == "msys" ]]; then
    echo "Sistema operativo: Windows"
else
    echo "Sistema operativo no reconocido"
fi
