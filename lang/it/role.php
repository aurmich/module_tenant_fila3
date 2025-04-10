<?php

return array (
  'navigation' => 
  array (
    'name' => 'Ruoli',
    'plural' => 'Ruoli',
    'group' => 
    array (
      'name' => 'Gestione Utenti',
      'description' => 'Gestione dei ruoli e dei permessi associati',
    ),
    'label' => 'Ruoli',
    'sort' => 26,
    'icon' => 'user-role-animated',
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'tooltip' => 'Identificativo univoco del ruolo',
    ),
    'team_id' => 
    array (
      'label' => 'ID Team',
      'tooltip' => 'Identificativo del team associato al ruolo',
    ),
    'name' => 
    array (
      'label' => 'Nome Ruolo',
      'tooltip' => 'Il nome identificativo del ruolo, es. "Admin".',
      'placeholder' => 'Nome del ruolo',
    ),
    'guard_name' => 
    array (
      'label' => 'Guard',
      'tooltip' => 'Il nome della guardia per questo ruolo, es. "web".',
      'placeholder' => 'Nome della guardia',
    ),
    'permissions' => 
    array (
      'label' => 'Permessi',
      'tooltip' => 'Seleziona i permessi associati a questo ruolo.',
      'placeholder' => 'Seleziona permessi',
    ),
    'users_count' => 
    array (
      'label' => 'Numero Utenti',
      'tooltip' => 'Il numero di utenti assegnati a questo ruolo.',
    ),
    'created_at' => 
    array (
      'label' => 'Data Creazione',
      'tooltip' => 'La data in cui il ruolo è stato creato.',
      'placeholder' => 'Data di creazione',
    ),
    'updated_at' => 
    array (
      'label' => 'Ultima Modifica',
      'tooltip' => 'La data dell\'ultima modifica del ruolo.',
      'placeholder' => 'Ultima modifica',
    ),
    'description' => 
    array (
      'label' => 'Descrizione',
      'tooltip' => 'Una descrizione del ruolo e delle sue funzioni.',
      'placeholder' => 'Descrizione del ruolo',
    ),
    'toggleColumns' => 
    array (
      'label' => 'Mostra/Nascondi Colonne',
      'tooltip' => 'Gestisci la visibilità delle colonne',
    ),
    'reorderRecords' => 
    array (
      'label' => 'Riordina Record',
      'tooltip' => 'Modifica l\'ordine dei record',
    ),
    'resetFilters' => 
    array (
      'label' => 'Resetta Filtri',
      'tooltip' => 'Ripristina i filtri predefiniti',
    ),
    'applyFilters' => 
    array (
      'label' => 'Applica Filtri',
      'tooltip' => 'Applica i filtri selezionati',
    ),
    'openFilters' => 
    array (
      'label' => 'Apri Filtri',
      'tooltip' => 'Apri il pannello dei filtri',
    ),
    'detach' => 
    array (
      'label' => 'detach',
    ),
    'edit' => 
    array (
      'label' => 'edit',
    ),
    'recordId' => 
    array (
      'label' => 'recordId',
    ),
    'attach' => 
    array (
      'label' => 'attach',
    ),
  ),
  'roles' => 
  array (
    'super_admin' => 'Super Amministratore',
    'admin' => 'Amministratore',
    'manager' => 'Manager',
    'editor' => 'Editor',
    'user' => 'Utente',
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Ruolo',
      'tooltip' => 'Clicca per creare un nuovo ruolo nel sistema.',
      'icon' => 'fa fa-plus',
      'color' => 'success',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Ruolo',
      'tooltip' => 'Clicca per modificare questo ruolo.',
      'icon' => 'fa fa-edit',
      'color' => 'primary',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Ruolo',
      'tooltip' => 'Clicca per eliminare questo ruolo.',
      'icon' => 'fa fa-trash',
      'color' => 'danger',
    ),
    'assign_permissions' => 
    array (
      'label' => 'Assegna Permessi',
      'tooltip' => 'Clicca per assegnare permessi al ruolo.',
      'icon' => 'fa fa-check',
      'color' => 'info',
    ),
    'sync_permissions' => 
    array (
      'label' => 'Sincronizza Permessi',
      'tooltip' => 'Clicca per sincronizzare i permessi con quelli di un altro sistema.',
      'icon' => 'fa fa-sync',
      'color' => 'warning',
    ),
  ),
  'messages' => 
  array (
    'created' => 'Ruolo creato con successo',
    'updated' => 'Ruolo aggiornato con successo',
    'deleted' => 'Ruolo eliminato con successo',
    'permissions_updated' => 'Permessi aggiornati con successo',
    'cannot_delete_super_admin' => 'Non puoi eliminare il ruolo di Super Amministratore',
    'role_in_use' => 'Non puoi eliminare un ruolo assegnato a degli utenti',
  ),
  'descriptions' => 
  array (
    'super_admin' => 'Accesso completo a tutte le funzionalità del sistema.',
    'admin' => 'Accesso alla maggior parte delle funzionalità amministrative.',
    'manager' => 'Gestione di utenti e contenuti specifici.',
    'editor' => 'Modifica e gestione dei contenuti.',
    'user' => 'Accesso base alle funzionalità del sistema.',
  ),
  'permissions_groups' => 
  array (
    'users' => 'Gestione Utenti',
    'roles' => 'Gestione Ruoli',
    'content' => 'Gestione Contenuti',
    'settings' => 'Impostazioni',
    'reports' => 'Report',
  ),
  'validation' => 
  array (
    'name_required' => 'Il nome del ruolo è obbligatorio',
    'name_unique' => 'Questo nome ruolo è già in uso',
    'permissions_required' => 'Seleziona almeno un permesso',
  ),
  'model' => 
  array (
    'label' => 'Ruolo',
  ),
  'plural' => 
  array (
    'model' => 
    array (
      'label' => 'role.plural.model',
    ),
  ),
);
