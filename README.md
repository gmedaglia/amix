# Sales Challenge

## Before Interview
Build an API to manage sales for a company that markets products and services.

## Context
The API must allow:
- Manage clients
- Manage products and services
- Record sales
- Query sales information

## Basic Technical Requirements
- PHP 8+
- Laravel 10+
- Database of choice

## Business Rules
- A sale can include multiple products and/or services.
- Only products or services that have stock or are available can be sold.
- In the sales details, it must indicate the sale number made by that client on the same day. For example, the first
purchase of the day, the second purchase of the day, etc.
- A product cannot be sold to more than 3 clients on the same day.
- A service may depend on whether there is stock of a certain product or not.