# RMFEE

**RMFEE** is an application designed to manage budget proposals, approvals, and reporting processes within an organization. It is integrated with the **[EPO (LGI Fixed Asset)](https://github.com/Antonius1712/LGI-FIXED-ASSET)** system to facilitate automated asset number generation and email-based director approvals.

## Table of Contents
- [Overview](#overview)
- [Features](#features)
- [Technology Stack](#technology-stack)
- [Installation](#installation)
- [Configuration](#configuration)
- [Integration with EPO](#integration-with-epo)
- [Usage](#usage)
- [Cron Job Setup](#cron-job-setup)
- [Contact](#contact)

## Overview
The RMFEE application is a comprehensive tool for managing the entire lifecycle of budget proposals, from submission to approval and reporting. The system is tightly integrated with the **[EPO (LGI Fixed Asset)](https://github.com/Antonius1712/LGI-FIXED-ASSET)** system, enabling automated generation of asset numbers and streamlining the approval process through email notifications to directors.

## Features
- **Budget Proposal Management**: Submit and manage budget proposals with ease.
- **Approval Workflow**: Streamlined approval process with email notifications for directors.
- **Automated Asset Number Generation**: Integration with the **[EPO (LGI Fixed Asset)](https://github.com/Antonius1712/LGI-FIXED-ASSET)** system for automatic asset number generation.
- **Reporting**: Generate detailed reports on budget proposals, approvals, and asset management.
- **Email Notifications**: Automated email notifications for approvals and other key actions.

## Technology Stack
- **Backend**: [Laravel](https://laravel.com/) - A powerful PHP framework for handling server-side logic.
- **Database**: [MSSQL](https://www.microsoft.com/en-us/sql-server/sql-server-downloads) - A robust relational database management system for storing application data.
- **Email**: Laravel's built-in email functionality for sending notifications.
- **Integration**: Tight integration with the **[EPO (LGI Fixed Asset)](https://github.com/Antonius1712/LGI-FIXED-ASSET)** system.

## Installation

### Prerequisites
- [PHP](https://www.php.net/) >= 7.4
- [Composer](https://getcomposer.org/) for dependency management
- [MSSQL](https://www.microsoft.com/en-us/sql-server/sql-server-downloads) for the database

### Steps
1. **Clone the repository**:
   ```bash
   git clone https://github.com/Antonius1712/RMFEE
   cd rmfee
   ```
2. **Install backend dependencies**:
   ```bash
   composer install
   ```
3. **Environment setup**:
   Copy `.env.example` to `.env`:
   ```bash
   cp .env.example .env
   ```
   Configure the .env file with your MSSQL database credentials and other environment-specific variables.

4. **Database migration: Run the migrations to set up the required tables in your MSSQL database**:
   ```bash
   php artisan migrate
   ```
5. **Generate application key**:
   ```bash
   php artisan key:generate
   ```
6. **Start the development server**:
   ```bash
   php artisan serve
   ```
7. **Access the application: Open your browser and navigate to http://localhost:8000**


## Configuration

Edit the `.env` file to configure your database connection, mail server, and other environment-specific settings. Ensure the integration with the **[EPO (LGI Fixed Asset)](https://github.com/Antonius1712/LGI-FIXED-ASSET)** system is properly configured.

## Integration with EPO

The RMFEE application is integrated with the **[EPO (LGI Fixed Asset)](https://github.com/Antonius1712/LGI-FIXED-ASSET)** system to automate asset number generation and manage the approval process. Make sure the EPO system is up and running, and that the necessary API keys or connection strings are set up in the `.env` file.

## Usage

- **Submit Budget Proposals**: Users can submit budget proposals, which will be automatically processed and sent for approval.
- **Approval Workflow**: Directors receive email notifications for approvals, and the system generates asset numbers through the EPO integration.
- **Reporting**: Generate reports on all budget activities and asset management.

## Cron Job Setup

To ensure that the application runs as a scheduled job, set up a cron job on your server:

1. Open the crontab file:
    ```bash
    crontab -e
    ```
2. Add the following line to schedule the job:
    ```bash
    * * * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1
    ```
    Replace /path-to-your-project/ with the actual path to your Laravel project. Adjust the cron timing (* * * * *) based on your scheduling needs.

## Contact

For any questions or support, please reach out to:

- **Name**: Antonius Christian
- **Email**: antonius1712@gmail.com
- **Phone**: +6281297275563
- **LinkedIn**: [Antonius Christian](https://www.linkedin.com/in/antonius-christian/)

Feel free to connect with me via email or LinkedIn for any inquiries or further information.