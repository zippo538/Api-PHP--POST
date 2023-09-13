## API TRANSFER SPEC

# Create Transfer API

Endpoint: /api/transactions

Method: POST

Step by step transfer dana:
1. API check pada akun sumber dana, apakah saldo mencukupi
2. Ambil uang dari akun sumber dana
3. Tambahkan uang ke akun tujuan
4. Buat record baru

Request body :

```json
{
  "rekTujuan" : "1487623123",
  "nominal" : "5000000",
}
```
Response Success body :
```json
{
  "idRek" : "234551",
  "rekTujuan" : "1487623123",
  "nominal" : "Rp.5.000.000,00",
  "tanggal" : "21-06-2023",
  "status" : "success",
}
```

idTransfer

rektujuan

rekasal

nominal

tgltf

status



