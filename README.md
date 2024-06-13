## Setup Kafka

### Create Topics

```bash
docker compose exec -it kafka kafka-topics.sh --bootstrap-server localhost:9092 --create --topic logistic
```

### Consumer Groups

```bash
docker compose exec -it kafka kafka-console-consumer.sh --bootstrap-server localhost:9092 --group logistic --topic logistic --from-beginning
```

### Consumer

```bash
docker compose exec -it consumer php artisan kafka:consume logistic --group=logistics
```

### Consumer

```bash
docker compose exec -it consumer php artisan kafka:consume logistic --group=logistics
```

## Producer
```bash
docker compose exec -it consumer php artisan kafka:producer 1007:Hei 1008:World --topic=logistic
```