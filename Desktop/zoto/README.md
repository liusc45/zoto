# 🐳 Docker Registry - Zot

Private Docker registry using [Zot](https://zotregistry.io/) as OCI registry server.

---

## 🌐 Registry URL

```
https://registry.luam.ovh
```

---

## 🔑 Credentials

### 👤 Public User (Read-Only)

| Field | Value |
|-------|-------|
| **Username** | `public` |
| **Password** | `Gratis123` |
| **Access** | Pull-only 🚫 Push |

### 🛠️ Admin User (Full Access)

| Field | Value |
|-------|-------|
| **Username** | `admin` |
| **Password** | Generate your own |
| **Access** | Pull & Push ✅ |

---

## 📥 Login

```bash
# Public user (read-only)
docker login registry.luam.ovh -u public -p Gratis123

# Admin user
docker login registry.luam.ovh -u admin -p YOUR_ADMIN_PASSWORD
```

---

## 🏷️ Example Pulls

```bash
# Python
docker pull registry.luam.ovh/python:3.12-alpine

# Node.js
docker pull registry.luam.ovh/node:20-alpine

# JDK/OpenJDK
docker pull registry.luam.ovh/azul/zulu-openjdk:21

# Distroless
docker pull registry.luam.ovh/gcr.io/distroless/base-debian12:nonroot
```

---

## ❌ What You CANNOT Do (Public User)

```bash
# Returns 403 (read-only)
docker push registry.luam.ovh/imagen:tag
```

---

## 🔐 Configuration

### 1. Domain Setup

Edit `.env` file:

```env
CADDY_DOMAIN=registry.YOUR-DOMAIN.com
```

### 2. Password Hashes

Generate and add your password hashes:

```env
CADDY_ADMIN_PASSWORD_HASH=$2a$14$...
CADDY_PUBLIC_PASSWORD_HASH=$2a$14$...
```

---

## 🚀 Quick Start

```bash
# 1. Configure .env file (domain + password hashes)
#    cp .env.example .env
#    Edit .env and add your values

# 2. Start services
docker-compose up -d

# View logs
docker-compose logs -f

# Restart Caddy after config changes
docker-compose up -d --force-recreate caddy

# Stop
docker-compose down
```

---

## 📂 Project Structure

```
├── docker-compose.yml   # Services configuration
├── Caddyfile            # Caddy reverse proxy
├── .env.example         # Environment template
├── .env                 # Configuration (domain + password hashes)
├── config.json          # Zot configuration
├── data/                # Registry data directory
└── README.md            # This file
```

---

## 🔧 Configuration

### Ports

| Port | Service |
|------|---------|
| 80/443 | HTTP/HTTPS via Caddy |

### Network

`internal` - isolated network between Zot and Caddy

---

## ⚠️ Security Best Practices

- ✅ Store only password **hashes** in `.env`
- ❌ Never commit `.env` to version control (add to `.gitignore`)
- ✅ Use different passwords for admin and public users
- ✅ Generate new hashes when changing passwords

---

## 📝 License

MIT
