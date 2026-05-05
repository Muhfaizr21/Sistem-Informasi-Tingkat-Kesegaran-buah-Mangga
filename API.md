# 🔌 API Links & Services
## Sistem Informasi Tingkat Kesegaran Buah Mangga

---

## ⚡ WEATHER API (untuk Rekomendasi Panen/Tanam)

### 1. OpenWeatherMap (Recommended)
- **Website:** https://openweathermap.org/
- **Pricing:** Free tier + Pro ($40/bulan)
- **Docs:** https://openweathermap.org/forecast5
- **Sign Up:** https://openweathermap.org/api
- **Use Case:** 5-14 hari forecast, temperature, humidity, rainfall

### 2. WeatherAPI.com (Alternative)
- **Website:** https://www.weatherapi.com/
- **Pricing:** Free (1M calls/month) + Pro ($8/bulan)
- **Docs:** https://www.weatherapi.com/docs/
- **Sign Up:** https://www.weatherapi.com/signup.aspx
- **Use Case:** Detailed forecast dengan rainfall probability, UV index

### 3. BMKG (Indonesia-specific, Free)
- **Website:** https://data.bmkg.go.id/
- **Docs:** https://data.bmkg.go.id/tentang/
- **Data API:** https://data.bmkg.go.id/gmap.bmkg.go.id
- **Use Case:** Data cuaca Indonesia yang akurat

### 4. Open-Meteo (Free, No API Key)
- **Website:** https://open-meteo.com/
- **Docs:** https://open-meteo.com/en/docs
- **API:** https://api.open-meteo.com/v1/forecast
- **Pricing:** Completely Free
- **Use Case:** Cuaca tanpa authentication, cocok untuk MVP

---

## 💳 PAYMENT GATEWAY (untuk Transaksi Pembeli)

### 1. Midtrans (Recommended untuk Indonesia)
- **Website:** https://midtrans.com/
- **Docs:** https://docs.midtrans.com/
- **Dashboard:** https://dashboard.midtrans.com/
- **Sign Up:** https://midtrans.com/register
- **Pricing:** 1.5% - 3% per transaksi
- **Support:** Bank transfer, E-wallet (OVO, GoPay, DANA), Credit Card, BNPL

### 2. Stripe (International)
- **Website:** https://stripe.com/
- **Docs:** https://stripe.com/docs
- **Pricing:** 2.9% + Rp 2,000 per transaksi
- **Use Case:** Jika ekspansi ke internasional

### 3. Xendit (Indonesia-specific)
- **Website:** https://www.xendit.co/
- **Docs:** https://xendit.readme.io/
- **Pricing:** 1% - 3% per transaksi
- **Support:** Bank transfer, E-wallet, Virtual Account

### 4. iPaymu (Indonesia-specific)
- **Website:** https://www.ipaymu.com/
- **Docs:** https://documenter.getpostman.com/view/21662862/2s9YkgFnzP
- **Pricing:** 2.5% per transaksi
- **Use Case:** Lebih murah, cocok untuk UMKM

---

## 📧 EMAIL SERVICE (untuk Notifikasi)

### 1. SendGrid (Recommended)
- **Website:** https://sendgrid.com/
- **Docs:** https://docs.sendgrid.com/
- **Sign Up:** https://signup.sendgrid.com/
- **Pricing:** Free 100 emails/hari + Pro
- **Use Case:** Email notifikasi order, verifikasi, laporan

### 2. Mailgun
- **Website:** https://www.mailgun.com/
- **Docs:** https://documentation.mailgun.com/
- **Pricing:** Free 100 emails/hari + Pro
- **Use Case:** Email transaksional, reliable

### 3. AWS SES (Ekonomis)
- **Website:** https://aws.amazon.com/ses/
- **Docs:** https://docs.aws.amazon.com/ses/
- **Pricing:** $0.10 per 1000 emails
- **Use Case:** Skala besar dengan budget terbatas

---

## 📱 SMS SERVICE (untuk Notifikasi)

### 1. Twilio
- **Website:** https://www.twilio.com/
- **Docs:** https://www.twilio.com/docs/sms
- **Pricing:** $0.0075 per SMS
- **Sign Up:** https://www.twilio.com/console/
- **Use Case:** SMS notifikasi real-time

### 2. AWS SNS
- **Website:** https://aws.amazon.com/sns/
- **Docs:** https://docs.aws.amazon.com/sns/
- **Pricing:** $0.50 per SMS
- **Use Case:** Terintegrasi dengan AWS stack

### 3. Nexmo/Vonage
- **Website:** https://www.vonage.com/
- **Docs:** https://developer.vonage.com/sms/sms-overview
- **Pricing:** $0.02 - $0.10 per SMS
- **Use Case:** SMS + Voice calls

---

## 🗺️ MAPPING & GIS (untuk Visualisasi Lahan)

### 1. Google Maps API (Recommended)
- **Website:** https://developers.google.com/maps
- **Docs:** https://developers.google.com/maps/documentation
- **Sign Up:** https://console.cloud.google.com/
- **Pricing:** Pay-as-you-go (~$7 per 1000 requests)
- **Use Case:** Map display, location picker, distance calculation

### 2. Mapbox
- **Website:** https://www.mapbox.com/
- **Docs:** https://docs.mapbox.com/
- **Pricing:** Free tier + Pro
- **Use Case:** Custom map styling, heatmap

### 3. Leaflet (Free, Open Source)
- **Website:** https://leafletjs.com/
- **Docs:** https://leafletjs.com/reference.html
- **Pricing:** Free
- **Use Case:** Lightweight map library (frontend only)

### 4. OpenStreetMap (Free)
- **Website:** https://www.openstreetmap.org/
- **Docs:** https://wiki.openstreetmap.org/wiki/API
- **Pricing:** Free
- **Use Case:** Mapping tanpa commercial use limit

---

## 🔐 AUTHENTICATION & SECURITY

### 1. Auth0 (Optional, untuk advanced auth)
- **Website:** https://auth0.com/
- **Docs:** https://auth0.com/docs
- **Pricing:** Free + Pro
- **Use Case:** OAuth, 2FA, SSO, Social login

### 2. Firebase Authentication (Alternative)
- **Website:** https://firebase.google.com/docs/auth
- **Docs:** https://firebase.google.com/docs/auth
- **Pricing:** Free
- **Use Case:** Email/password, Phone auth, Social login

---

## 🤖 ML/AI SERVICES (untuk Model Deployment)

### 1. TensorFlow Serving (On-premise)
- **Website:** https://www.tensorflow.org/tfx/guide/serving
- **Docs:** https://www.tensorflow.org/tfx/serving
- **Pricing:** Free (self-hosted)
- **Use Case:** Deploy ML model untuk scan kesegaran

### 2. AWS SageMaker (Cloud-based)
- **Website:** https://aws.amazon.com/sagemaker/
- **Docs:** https://docs.aws.amazon.com/sagemaker/
- **Pricing:** Pay-as-you-go
- **Use Case:** Managed ML service dengan auto-scaling

### 3. Google Cloud AI Platform (Alternative)
- **Website:** https://cloud.google.com/ai-platform
- **Docs:** https://cloud.google.com/ai-platform/docs
- **Pricing:** Pay-as-you-go
- **Use Case:** Terintegrasi dengan Google Cloud

### 4. Hugging Face Inference API (for Pre-trained models)
- **Website:** https://huggingface.co/
- **Docs:** https://huggingface.co/docs/hub/inference-api
- **Pricing:** Free + Pro
- **Use Case:** Deploy pre-trained vision models

---

## 💾 DATABASE & STORAGE

### 1. Firebase/Firestore (Simple)
- **Website:** https://firebase.google.com/
- **Docs:** https://firebase.google.com/docs/firestore
- **Pricing:** Free tier + Pay-as-you-go
- **Use Case:** NoSQL database, real-time sync

### 2. AWS RDS PostgreSQL (Recommended)
- **Website:** https://aws.amazon.com/rds/
- **Docs:** https://docs.aws.amazon.com/rds/
- **Pricing:** ~$15-50/bulan untuk small instance
- **Use Case:** Managed PostgreSQL dengan backup

### 3. DigitalOcean Managed Database
- **Website:** https://www.digitalocean.com/products/managed-databases/
- **Docs:** https://docs.digitalocean.com/products/databases/
- **Pricing:** $15/bulan untuk shared cluster
- **Use Case:** More affordable than AWS

### 4. AWS S3 (File Storage)
- **Website:** https://aws.amazon.com/s3/
- **Docs:** https://docs.aws.amazon.com/s3/
- **Pricing:** ~$0.023 per GB/bulan
- **Use Case:** Store photos, scans, backups

---

## 📊 ANALYTICS & MONITORING

### 1. Google Analytics 4
- **Website:** https://analytics.google.com/
- **Docs:** https://support.google.com/analytics
- **Pricing:** Free
- **Use Case:** Track user behavior, conversion

### 2. Sentry (Error Tracking)
- **Website:** https://sentry.io/
- **Docs:** https://docs.sentry.io/
- **Pricing:** Free + Pro
- **Use Case:** Real-time error monitoring

### 3. New Relic (APM)
- **Website:** https://newrelic.com/
- **Docs:** https://docs.newrelic.com/
- **Pricing:** Free tier + Pro
- **Use Case:** Application performance monitoring

### 4. Datadog (Monitoring)
- **Website:** https://www.datadoghq.com/
- **Docs:** https://docs.datadoghq.com/
- **Pricing:** ~$15/host/bulan
- **Use Case:** Infrastructure monitoring

---

## 🔔 PUSH NOTIFICATION

### 1. Firebase Cloud Messaging (Recommended)
- **Website:** https://firebase.google.com/docs/cloud-messaging
- **Docs:** https://firebase.google.com/docs/cloud-messaging
- **Pricing:** Free
- **Use Case:** Push notification untuk iOS/Android

### 2. OneSignal (User-friendly)
- **Website:** https://onesignal.com/
- **Docs:** https://documentation.onesignal.com/
- **Pricing:** Free + Pro
- **Use Case:** Push notification dengan segmentation

---

## 🎓 ML MODEL TRAINING PLATFORMS

### 1. Google Colab (Free)
- **Website:** https://colab.research.google.com/
- **Use Case:** Training ML models untuk scan kesegaran

### 2. Kaggle (Free)
- **Website:** https://www.kaggle.com/
- **Use Case:** Dataset untuk training, kernels untuk development

### 3. AWS Lambda (Serverless)
- **Website:** https://aws.amazon.com/lambda/
- **Docs:** https://docs.aws.amazon.com/lambda/
- **Use Case:** Run ML inference tanpa server

---

## 📋 SUMMARY - RECOMMENDED STACK

### **Option 1: Budget-Friendly (Perfect untuk MVP)**
```
Weather: Open-Meteo (FREE)
Payment: iPaymu atau Midtrans (2.5-3%)
Email: SendGrid (FREE 100/hari)
SMS: Twilio (optional, $0.0075/SMS)
Maps: OpenStreetMap + Leaflet (FREE)
DB: DigitalOcean PostgreSQL ($15/bulan)
Storage: DigitalOcean Spaces ($5/bulan)
ML Model: Local TensorFlow Lite (FREE)
Hosting: DigitalOcean App Platform ($5-12/bulan)
Auth: Manual JWT (FREE)
Total: ~$35-50/bulan
```

### **Option 2: Full-Featured (Production)**
```
Weather: OpenWeatherMap Pro ($40/bulan)
Payment: Midtrans (2.9%)
Email: SendGrid Pro (~$30/bulan)
SMS: Twilio ($200+/bulan)
Maps: Google Maps API (~$100-200/bulan usage)
DB: AWS RDS PostgreSQL ($50/bulan)
Storage: AWS S3 (~$20/bulan)
ML Model: AWS SageMaker (~$100+/bulan)
Hosting: AWS EC2 + Load Balancer (~$200/bulan)
Monitoring: Sentry Pro + New Relic (~$100/bulan)
Auth: Auth0 (~$100/bulan)
Total: ~$800-1500/bulan (depends on usage)
```

### **Option 3: Balanced (Recommended)**
```
Weather: OpenWeatherMap Free (or WeatherAPI)
Payment: Midtrans
Email: SendGrid Free/Pro
SMS: Optional (Twilio saat ada budget)
Maps: Google Maps API (but optimize usage)
DB: AWS RDS PostgreSQL ($50/bulan)
Storage: AWS S3 ($20/bulan)
ML Model: Local TensorFlow Lite atau SageMaker (minimal)
Hosting: DigitalOcean App Platform + AWS ($50-100/bulan)
Monitoring: Sentry Free + basic CloudWatch
Auth: Manual JWT + Firebase optional
Total: ~$150-250/bulan
```

---

## 🚀 QUICK START CHECKLIST

### Wajib (untuk MVP):
- [ ] OpenWeatherMap / Open-Meteo (Weather)
- [ ] Midtrans / iPaymu (Payment)
- [ ] SendGrid (Email)
- [ ] Google Maps API atau OpenStreetMap (Maps)
- [ ] PostgreSQL Database (DigitalOcean / AWS RDS)
- [ ] AWS S3 atau DigitalOcean Spaces (Photo Storage)

### Penting (Phase 2):
- [ ] Firebase FCM atau OneSignal (Push Notification)
- [ ] Twilio (SMS)
- [ ] Sentry (Error Tracking)
- [ ] Firebase Authentication (Social Login)

### Optional (Phase 3+):
- [ ] AWS SageMaker (Advanced ML)
- [ ] Auth0 (Enterprise Auth)
- [ ] Datadog (Advanced Monitoring)
- [ ] Stripe (International Payments)

---

## 📞 Contact & Help

Jika ada pertanyaan tentang API integration:
1. Baca dokumentasi resmi dari setiap service
2. Cek pricing dan free tier limits
3. Test di sandbox/development terlebih dahulu
4. Setup monitoring untuk production