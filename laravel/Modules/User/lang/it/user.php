<?php

return array (
  'navigation' => 
  array (
    'name' => 'Utenti',
    'plural' => 'Utenti',
    'group' => 
    array (
      'name' => 'Gestione Utenti',
      'description' => 'Gestione degli utenti e dei loro permessi',
    ),
    'label' => 'Utenti',
    'sort' => 26,
    'icon' => 'user-main',
  ),
  'fields' => 
  array (
    'name' => 
    array (
      'label' => 'Nome',
      'placeholder' => 'Inserisci il nome',
    ),
    'email' => 
    array (
      'label' => 'Email',
      'placeholder' => 'Inserisci l\'email',
    ),
    'password' => 
    array (
      'label' => 'Password',
      'placeholder' => 'Inserisci la password',
    ),
    'password_confirmation' => 
    array (
      'label' => 'Conferma Password',
      'placeholder' => 'Conferma la password',
    ),
    'current_password' => 
    array (
      'label' => 'Password Attuale',
      'placeholder' => 'Inserisci la password attuale',
    ),
    'role' => 
    array (
      'label' => 'Ruolo',
    ),
    'roles' => 
    array (
      'label' => 'Ruoli',
    ),
    'permissions' => 
    array (
      'label' => 'Permessi',
    ),
    'status' => 
    array (
      'label' => 'Stato',
      'options' => 
      array (
        'active' => 'Attivo',
        'inactive' => 'Inattivo',
        'blocked' => 'Bloccato',
      ),
    ),
    'last_login' => 
    array (
      'label' => 'Ultimo Accesso',
    ),
    'created_at' => 
    array (
      'label' => 'Data Creazione',
    ),
    'updated_at' => 
    array (
      'label' => 'Ultima Modifica',
    ),
    'avatar' => 
    array (
      'label' => 'Avatar',
    ),
    'language' => 
    array (
      'label' => 'Lingua',
    ),
    'timezone' => 
    array (
      'label' => 'Fuso Orario',
    ),
    'password_expires_at' => 
    array (
      'label' => 'Scadenza Password',
    ),
    'verified' => 
    array (
      'label' => 'Verificato',
    ),
    'unverified' => 
    array (
      'label' => 'Non Verificato',
    ),
    'create' => 
    array (
      'label' => 'create',
    ),
    'applyFilters' => 
    array (
      'label' => 'applyFilters',
    ),
    'toggleColumns' => 
    array (
      'label' => 'toggleColumns',
    ),
    'reorderRecords' => 
    array (
      'label' => 'reorderRecords',
    ),
    'resetFilters' => 
    array (
      'label' => 'resetFilters',
    ),
    'openFilters' => 
    array (
      'label' => 'openFilters',
    ),
    'isActive' => 
    array (
      'label' => 'isActive',
    ),
    'deactivate' => 
    array (
      'label' => 'deactivate',
    ),
    'id' => 
    array (
      'label' => 'ID',
    ),
    'email_verified_at' => 
    array (
      'label' => 'Email Verified At',
    ),
    'view' => 
    array (
      'label' => 'view',
    ),
    'edit' => 
    array (
      'label' => 'edit',
    ),
    'delete' => 
    array (
      'label' => 'delete',
    ),
  ),
  'actions' => 
  array (
    'create' => 'Crea Utente',
    'edit' => 'Modifica Utente',
    'delete' => 'Elimina Utente',
    'impersonate' => 'Impersona Utente',
    'stop_impersonating' => 'Termina Impersonificazione',
    'block' => 'Blocca',
    'unblock' => 'Sblocca',
    'send_reset_link' => 'Invia Link Reset Password',
    'verify_email' => 'Verifica Email',
  ),
  'messages' => 
  array (
    'created' => 'Utente creato con successo',
    'updated' => 'Utente aggiornato con successo',
    'deleted' => 'Utente eliminato con successo',
    'blocked' => 'Utente bloccato con successo',
    'unblocked' => 'Utente sbloccato con successo',
    'reset_link_sent' => 'Link per il reset della password inviato',
    'email_verified' => 'Email verificata con successo',
    'impersonating' => 'Stai impersonando l\'utente :name',
  ),
  'validation' => 
  array (
    'email_unique' => 'Questa email è già in uso',
    'password_min' => 'La password deve essere di almeno :min caratteri',
    'password_confirmed' => 'Le password non coincidono',
    'current_password' => 'La password attuale non è corretta',
  ),
  'permissions' => 
  array (
    'view_users' => 'Visualizza utenti',
    'create_users' => 'Crea utenti',
    'edit_users' => 'Modifica utenti',
    'delete_users' => 'Elimina utenti',
    'impersonate_users' => 'Impersona utenti',
    'manage_roles' => 'Gestisci ruoli',
  ),
  'model' => 
  array (
    'label' => 'user.model',
  ),
);
