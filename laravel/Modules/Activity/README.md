# Module Activity Fila3 🔥 Ultimate Task Management & Productivity Tracker 🚀
[![Latest Version on Packagist](https://img.shields.io/packagist/v/laraxot/module_activity_fila3.svg?style=flat-square)](https://packagist.org/packages/laraxot/module_activity_fila3)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/laraxot/module_activity_fila3/run-tests?label=tests)](https://github.com/laraxot/module_activity_fila3/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/laraxot/module_activity_fila3/Check%20&%20fix%20styling?label=code%20style)](https://github.com/laraxot/module_activity_fila3/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/laraxot/module_activity_fila3.svg?style=flat-square)](https://packagist.org/packages/laraxot/module_activity_fila3)
[![Latest Release](https://img.shields.io/github/v/release/laraxot/module_activity_fila3)](https://github.com/laraxot/module_activity_fila3/releases)
[![Build Status](https://img.shields.io/travis/laraxot/module_activity_fila3/master)](https://travis-ci.org/laraxot/module_activity_fila3)
[![Total Downloads](https://img.shields.io/packagist/dt/laraxot/module_activity_fila3)](https://packagist.org/packages/laraxot/module_activity_fila3)
[![License](https://img.shields.io/github/license/laraxot/module_activity_fila3)](LICENSE)


Elevate your productivity to the next level! **Module Activity Fila3** is designed to help users manage tasks, track progress, and stay organized. Whether you're handling daily activities or long-term goals, this module has you covered! 📅

---

### Key Features 🌟
- **Task Management**: Easily create, edit, and delete tasks.
- **Progress Tracking**: Track your progress over daily, weekly, and monthly activities.
- **Smart Notifications**: Never miss a task with reminders and overdue notifications.
- **Performance Statistics**: Visualize your activity completion statistics and boost your productivity.

---

### Installation Guide 💻

1. **Install via Git Submodule:**
    ```bash
    git submodule add https://github.com/laraxot/module_activity_fila3.git Activity
    ```

2. **Run Migrations:**
    ```bash
    php artisan module:migrate Activity
    ```

3. **Verify the Module is Active:**
    ```bash
    php artisan module:list
    ```
    Enable it if necessary:
    ```bash
    php artisan module:enable Activity
    ```

---

### Supercharged Console Commands 🚀

- **View Activities:**
    ```bash
    php artisan activity:list
    ```
    _List all activities with their progress._

- **Create New Task:**
    ```bash
    php artisan activity:create <task_name>
    ```
    _Easily create a new task._

- **Track Progress:**
    ```bash
    php artisan activity:progress <task_id>
    ```
    _Track the progress of a specific task._

---

### Configuration 🔧

Tweak the behavior of this module through its config file, ensuring it fits perfectly into your workflow.

---

### FAQ ❓

- **Q: How do I receive notifications for overdue tasks?**
  A: Notifications are automatically generated based on the due date of each task.

- **Q: Can I track long-term goals?**
  A: Absolutely! The module allows for tracking over different time frames, including daily, weekly, and monthly views.

---

### Author 👨‍💻

Developed and maintained by [Marco Sottana](https://github.com/marco76tv)  
📧 Email: marco.sottana@gmail.com

---

### License 📄

This package is open-sourced under the [MIT license](LICENSE).

---

Get organized, track your tasks, and **boost your productivity** with **Module Activity Fila3**! 💥

A dedicated module that allows users to efficiently monitor and manage their daily activities. The project's goal is to help users stay productive, track their progress, and better manage their time.

## Main Features

- **Task Management**: Create, edit, and delete tasks.
- **Progress Tracking**: Track the progress of your daily, weekly, or monthly activities.
- **Notifications**: Receive reminders for upcoming or overdue tasks.
- **Statistics**: View statistics on your completed activities over time.

## Prerequisites
- php v8+
- laravel
- **[Xot Module](https://github.com/laraxot/module_xot_fila3.git)** (Required)
- **[Tenant Module](https://github.com/laraxot/module_tenant_fila3.git)** (Required)
- **[UI Module](https://github.com/laraxot/module_ui_fila3.git)** (Required)

## Add Module to the Project Base
Inside the `laravel/Modules` folder:

```bash
git submodule add https://github.com/laraxot/module_activity_fila3.git Activity
```

## Verify the Module is Active
```bash
php artisan module:list
```
If necessary, enable it:
```bash
php artisan module:enable Activity
```

## Run the Migrations
```bash
php artisan module:migrate Activity
```

