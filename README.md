# Netflix Cookies Checker By ./Mr.Dark

## Introduction
This PHP script checks the login status of Netflix accounts using stored cookies. It retrieves the list of user profiles associated with each account and indicates whether the login was successful or not.

## Usage

1. **Prepare Cookies:**
   Place your Netflix account cookies in the `cookies/` directory. Each cookie file should contain the necessary session information.

2. **Execute the Script:**
   Run the script `NetflixChecker.php`. It will iterate through the cookie files, attempting to log in to each account and retrieve the associated user profiles.

3. **Check Results:**
   After execution, the script will indicate whether the login was successful for each account. Successful logins will move the cookie file to the `cookies/works/` directory and generate a JSON file containing the list of user profiles.

## Requirements

- PHP (with cURL extension enabled)
- Netflix account cookies (stored in individual files)

## Installation

1. Clone this repository to your local machine and run it.
   ```bash
   git clone https://github.com/iiMrDark/NetFlix-CookiesChecker
   cd NetFlix-CookiesChecker
   php NetflixChecker.php
  
2. Place your Netflix cookies in the `cookies/` directory.
3. Ensure that the `cookies/works/` directory exists. If not, create it manually.

