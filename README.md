## Setup Kafka

### Create Topics

```bash
docker compose exec -it kafka kafka-topics.sh --bootstrap-server localhost:9092 --create --topic logistic
```

### Consumer Groups

```bash
docker compose exec -it kafka kafka-console-consumer.sh --bootstrap-server localhost:9092 --group logistic --topic logistic --from-beginning
```

