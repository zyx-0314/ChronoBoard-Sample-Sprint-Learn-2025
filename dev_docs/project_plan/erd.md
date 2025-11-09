# Database Schema for RBAC MVP

## Overview

This document outlines the minimum viable product (MVP) database schema for implementing Role-Based Access Control (RBAC) with three roles: Super Admin, Members, and Managers.

## Tables

### users

Stores user account information.

| Column          | Type         | Constraints                                           | Description                                                      |
| --------------- | ------------ | ----------------------------------------------------- | ---------------------------------------------------------------- |
| id              | INT          | PRIMARY KEY, AUTO_INCREMENT                           | Unique user identifier                                           |
| username        | VARCHAR(255) | UNIQUE, NOT NULL                                      | User's login username                                            |
| first_name      | VARCHAR(255) | NOT NULL                                              | User's first name                                                |
| middle_name     | VARCHAR(255) |                                                       | User's middle name                                               |
| last_name       | VARCHAR(255) | NOT NULL                                              | User's last name                                                 |
| role            | VARCHAR(255) | DEFAULT MEMBER                                        | User's role                                                      |
| email           | VARCHAR(255) | UNIQUE, NOT NULL                                      | User's email address                                             |
| verified_email  | TINYINT(1)   | NOT NULL                                              | Verfied Boolean                                                  |
| password_unhash | VARCHAR(255) | NOT NULL                                              | Unhashed password (only used when in dev mode or using super ad) |
| password_hash   | VARCHAR(255) | NOT NULL                                              | Hashed password                                                  |
| created_at      | TIMESTAMP    | DEFAULT CURRENT_TIMESTAMP                             | Account creation time                                            |
| updated_at      | TIMESTAMP    | DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | Last update time                                                 |
| deleted_at      | TIMESTAMP    |                                                       | Delete date                                                      |

## Initial Data

### Roles to Insert

1. Super Admin - Full system access
2. Manager - Can manage team members and projects
3. Member - Basic user access
