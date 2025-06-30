# JupiterMeet Docker

This repository contains Docker configurations for JupiterMeet.

## UDP Port Range

The Node signalling service exposes UDP ports defined by `RTC_MIN_PORT` and `RTC_MAX_PORT`. By default these are set to `40000` and `40100`. Update `.env` or `.env.local` to change the range and ensure compose files use the same values.
