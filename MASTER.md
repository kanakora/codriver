# Kanakora E-Learning Portal Generation Prompt (Laravel + Vue + Inertia)

## Role

You are a senior full-stack engineer and system architect experienced with Laravel, Vue 3, Inertia.js, Pinia, and RBAC design. Your task is to design and scaffold a production-ready e-learning portal focused strictly on static content delivery.

---

## Project Overview

Build a content-driven e-learning portal where:

- Admins can upload, categorize, manage, and publish learning materials
- Students can only view and search content
- There is no progress tracking, quizzes, rewards, certificates, or analytics
- The platform serves as a centralized knowledge hub for structured educational content

---

## Core Functional Requirements

### 1. User Roles & RBAC

Implement strict Role-Based Access Control (RBAC) using spatie/laravel-permission:

**Admin**

- Create, edit, publish, archive, and delete content
- Manage categories
- Upload files (PDFs, images, external links, text)
- Control content visibility

**Student**

- View published content only
- Search and filter content by category
- No write or administrative permissions

RBAC must be enforced at:

- Backend level (Laravel policies, gates, middleware)
- Frontend level (route guards, conditional rendering)

---

### 2. Content Management

Content must support the fields below and any additional you deem fit:

- Title
- Description
- Category (single or multiple)
- Content type (text, PDF, video, external link)
- Publish status (draft, published)
- Author (admin)
- Timestamps

Admins manage content through an admin dashboard.
Students can only access published content.

---

### 3. Categories & Search

- Content must be organized using categories
- Admins can create, edit, and delete categories
- Implement:
    - Category-based filtering
    - Keyword search (title and description)
- Optimize database queries for performance

---

### 4. Frontend Stack

- Vue 3 with Inertia.js
- Pinia for state management
    - User role and permissions
    - Categories and content lists
- Clear separation between admin and student views

Do not implement any progress indicators, completion states, or gamification UI elements.

---

### 5. Backend Stack

- Laravel backend
- Service classes where appropriate
- Authorization via policies
- Database migrations for:
    - Users
    - Roles
    - Content
    - Categories
    - Content-category pivot table

---

### 6. Security & Access Control

- Secure authentication using Laravel (Already implemented)
- Authorization enforced via middleware and policies
- All routes must be protected and enforce authorized access
- Prevent access to unpublished content
- Validate and securely store uploaded files - Upload files and images to local disk.

---

### 7. Explicit Non-Goals

Do not implement:

- Progress tracking or completion states
- Quizzes, exams, or scoring
- Certificates or rewards
- Student analytics or dashboards
- Gamification of any kind

This platform is strictly for content upload and consumption.

---

## Expected Output

Provide:

- High-level system architecture
- Database schema and relationships
- Laravel models, controllers, and policies
- Vue + Inertia page structure
- Pinia store structure
- RBAC implementation strategy
- Example admin and student user flows
- Best practices for scalability and maintainability
