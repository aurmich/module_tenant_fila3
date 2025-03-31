# Monitoraggio SaluteOra

## Strumenti

### Sentry
- Error tracking
- Performance monitoring
- User feedback
- Release tracking
- Issue management

### Laravel Telescope
- Request tracking
- Query logging
- Cache monitoring
- Queue jobs
- Mail tracking

### Prometheus
- Metrics collection
- Alerting
- Visualization
- Time series data
- Service discovery

## Configurazione

### Sentry
```php
// config/sentry.php
return [
    'dsn' => env('SENTRY_LARAVEL_DSN'),
    'breadcrumbs' => [
        'sql_queries' => true,
        'sql_bindings' => true,
        'queue_info' => true,
    ],
    'tracing' => [
        'queue_job_transactions' => env('SENTRY_TRACE_QUEUE_ENABLED', false),
        'sql_queries' => env('SENTRY_TRACE_SQL_QUERIES', false),
    ],
];
```

### Telescope
```php
// config/telescope.php
return [
    'enabled' => env('TELESCOPE_ENABLED', true),
    'ignore_paths' => [
        'nova-api*',
    ],
    'ignore_commands' => [
        //
    ],
    'watchers' => [
        Watchers\CacheWatcher::class => [
            'enabled' => env('TELESCOPE_CACHE_WATCHER', true),
        ],
        Watchers\CommandWatcher::class => [
            'enabled' => env('TELESCOPE_COMMAND_WATCHER', true),
        ],
        Watchers\DumpWatcher::class => [
            'enabled' => env('TELESCOPE_DUMP_WATCHER', true),
        ],
        Watchers\EventWatcher::class => [
            'enabled' => env('TELESCOPE_EVENT_WATCHER', true),
        ],
        Watchers\ExceptionWatcher::class => [
            'enabled' => env('TELESCOPE_EXCEPTION_WATCHER', true),
        ],
        Watchers\JobWatcher::class => [
            'enabled' => env('TELESCOPE_JOB_WATCHER', true),
        ],
        Watchers\LogWatcher::class => [
            'enabled' => env('TELESCOPE_LOG_WATCHER', true),
        ],
        Watchers\MailWatcher::class => [
            'enabled' => env('TELESCOPE_MAIL_WATCHER', true),
        ],
        Watchers\ModelWatcher::class => [
            'enabled' => env('TELESCOPE_MODEL_WATCHER', true),
        ],
        Watchers\NotificationWatcher::class => [
            'enabled' => env('TELESCOPE_NOTIFICATION_WATCHER', true),
        ],
        Watchers\QueryWatcher::class => [
            'enabled' => env('TELESCOPE_QUERY_WATCHER', true),
        ],
        Watchers\RedisWatcher::class => [
            'enabled' => env('TELESCOPE_REDIS_WATCHER', true),
        ],
        Watchers\RequestWatcher::class => [
            'enabled' => env('TELESCOPE_REQUEST_WATCHER', true),
        ],
        Watchers\ScheduleWatcher::class => [
            'enabled' => env('TELESCOPE_SCHEDULE_WATCHER', true),
        ],
        Watchers\ViewWatcher::class => [
            'enabled' => env('TELESCOPE_VIEW_WATCHER', true),
        ],
    ],
];
```

### Prometheus
```yaml
# prometheus.yml
global:
  scrape_interval: 15s
  evaluation_interval: 15s

scrape_configs:
  - job_name: 'laravel'
    static_configs:
      - targets: ['localhost:9090']
    metrics_path: '/metrics'
```

## Metriche

### Performance
```php
// Monitoraggio response time
$responseTime = microtime(true) - LARAVEL_START;

// Monitoraggio query
$queries = DB::getQueryLog();

// Monitoraggio memoria
$memory = memory_get_usage(true);
```

### Business
```php
// Monitoraggio utenti
$activeUsers = User::where('last_active_at', '>', now()->subDay())->count();

// Monitoraggio transazioni
$dailyTransactions = Transaction::whereDate('created_at', today())->count();

// Monitoraggio errori
$errorRate = Error::whereDate('created_at', today())->count();
```

## Alerting

### Regole
```yaml
# alertmanager.yml
groups:
  - name: laravel
    rules:
      - alert: HighErrorRate
        expr: rate(laravel_errors_total[5m]) > 0.1
        for: 5m
        labels:
          severity: critical
        annotations:
          summary: High error rate detected
          description: Error rate is above 10% for 5 minutes
```

### Notifiche
```php
// Notifiche Slack
$notification = new SlackNotification([
    'channel' => '#alerts',
    'username' => 'SaluteOra Bot',
    'icon' => ':warning:',
    'text' => 'Alert: High error rate detected',
]);
```

## Dashboard

### Grafana
```json
{
  "dashboard": {
    "id": null,
    "title": "SaluteOra Metrics",
    "panels": [
      {
        "title": "Response Time",
        "type": "graph",
        "datasource": "Prometheus",
        "targets": [
          {
            "expr": "rate(laravel_response_time_seconds_sum[5m]) / rate(laravel_response_time_seconds_count[5m])"
          }
        ]
      }
    ]
  }
}
```

### Custom Dashboard
```php
// resources/views/dashboard.blade.php
<div class="metrics-grid">
    <div class="metric-card">
        <h3>Response Time</h3>
        <div class="metric-value">{{ $avgResponseTime }}ms</div>
    </div>
    <div class="metric-card">
        <h3>Error Rate</h3>
        <div class="metric-value">{{ $errorRate }}%</div>
    </div>
    <div class="metric-card">
        <h3>Active Users</h3>
        <div class="metric-value">{{ $activeUsers }}</div>
    </div>
</div>
```

## Manutenzione

### Logs
```bash
# Rotazione logs
logrotate /etc/logrotate.d/laravel

# Pulizia logs vecchi
find /var/www/html/saluteora/storage/logs -type f -mtime +30 -delete
```

### Cache
```bash
# Pulizia cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
``` 