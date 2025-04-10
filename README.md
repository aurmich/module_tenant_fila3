# 🚀 BashScripts Power Tools

[![Bash Version](https://img.shields.io/badge/Bash-5.0%2B-brightgreen.svg)](https://www.gnu.org/software/bash/)
[![License](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)
[![Maintenance](https://img.shields.io/badge/Maintained%3F-yes-green.svg)](https://github.com/aurmich/bashscripts_fila3)
[![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg)](http://makeapullrequest.com)

<div align="center">
  <img src="https://raw.githubusercontent.com/odb/official-bash-logo/master/assets/Logos/Icons/PNG/512x512.png" width="200" alt="Bash Logo"/>
  <br/>
  <strong>Potenti script Bash per la gestione avanzata dei subtree Git 🌳</strong>
</div>

## 🌟 Caratteristiche Principali

- 🔄 **Sincronizzazione Automatica** dei subtree Git
- 🛡️ **Gestione Robusta degli Errori**
- 🔍 **Logging Dettagliato**
- 🚦 **Controlli di Sicurezza** integrati
- 🔧 **Manutenzione Semplificata**

## 📚 Indice

- [Installazione](#-installazione)
- [Utilizzo](#-utilizzo)
- [Script Disponibili](#-script-disponibili)
- [Esempi](#-esempi)
- [Risoluzione Problemi](#-risoluzione-problemi)
- [Contribuire](#-contribuire)

## 💻 Installazione

```bash
# Clona il repository
git clone git@github.com:aurmich/bashscripts_fila3.git

# Rendi gli script eseguibili
chmod +x *.sh
```

## 🚀 Utilizzo

### Sincronizzazione Subtree
```bash
./git_sync_subtree.sh <path> <remote_repo>
```

Esempio:
```bash
./git_sync_subtree.sh modules/auth git@github.com:user/auth-module.git
```

## 📜 Script Disponibili

### 1. git_sync_subtree.sh
> 🎯 Script principale per la sincronizzazione dei subtree

**Caratteristiche:**
- Gestione automatica di push e pull
- Rimozione caratteri CR (^M)
- Gestione permessi automatica

### 2. git_push_subtree.sh
> 🔼 Gestisce le operazioni di push

**Funzionalità:**
- Push intelligente con fallback
- Gestione branch temporanei
- Rebase automatico

### 3. git_pull_subtree.sh
> 🔽 Gestisce le operazioni di pull

**Caratteristiche:**
- Pull con squash opzionale
- Gestione conflitti automatica
- Merge strategy personalizzabile

## 🎯 Esempi

### Sincronizzazione Modulo
```bash
# Sincronizza un modulo specifico
./git_sync_subtree.sh modules/users git@github.com:org/users.git

# Sincronizza con branch specifico
REMOTE_BRANCH=develop ./git_sync_subtree.sh modules/auth git@github.com:org/auth.git
```

## ⚠️ Risoluzione Problemi

### Errori Comuni

1. **Prefix Option Mancante**
   ```bash
   fatal: you must provide the --prefix option
   ```
   ✅ **Soluzione:** Verifica il path del subtree

2. **Push Rejected**
   ```bash
   ! [rejected] dev -> dev (non-fast-forward)
   ```
   ✅ **Soluzione:** Esegui prima un pull

## 🛠️ Best Practices

1. **Prima dell'Esecuzione**
   - ✔️ Commit/stash delle modifiche pendenti
   - ✔️ Verifica branch corrente
   - ✔️ Controllo stato repository

2. **Durante l'Esecuzione**
   - 👀 Monitora l'output
   - ⏳ Non interrompere gli script
   - 📝 Controlla i log

## 🤝 Contribuire

Le contribuzioni sono sempre benvenute! Ecco come puoi aiutare:

1. 🍴 Forka il repository
2. 🔧 Crea un branch per le tue modifiche
3. 💻 Committa le tue migliorie
4. 📤 Pusha al branch
5. 🔄 Apri una Pull Request

## 📝 Note sulla Manutenzione

- 🔄 Aggiornamenti regolari
- 🐛 Fix bug tempestivi
- 📚 Documentazione sempre aggiornata

## 📜 Licenza

Questo progetto è sotto licenza MIT - vedi il file [LICENSE](LICENSE) per i dettagli.

## 👥 Autori

- **Marco Sottana** - *Lavoro Iniziale* - [aurmich](https://github.com/aurmich)

## 🙏 Ringraziamenti

- 🌟 Tutti i contributori
- 📚 La comunità Git
- 🔧 Gli utenti che segnalano bug

---

> **Nota**: Questo README è in continuo aggiornamento. Se trovi errori o hai suggerimenti, apri pure una issue!

<div align="center">
  <sub>Built with ❤️ by the development team</sub>
</div>
