<?php

namespace Nipwaayoni\Events;

final class DefaultEventFactory implements EventFactoryInterface
{
    /** @var SampleStrategy */
    private $transactionSamplingStrategy;

    public function __construct()
    {
        $this->transactionSamplingStrategy = new DefaultSampleStrategy();
    }

    /**
     * {@inheritdoc}
     */
    public function newError(\Throwable $throwable, array $contexts, ?Transaction $parent = null): Error
    {
        return new Error($throwable, $contexts, $parent);
    }

    /**
     * Sets the SamplingStrategy to use for Transactions
     *
     * @param SampleStrategy $strategy
     */
    public function setTransactionSampleStrategy(SampleStrategy $strategy): void
    {
        $this->transactionSamplingStrategy = $strategy;
    }

    /**
     * {@inheritdoc}
     */
    public function newTransaction(string $name, array $contexts): Transaction
    {
        $transaction = new Transaction($name, $contexts);
        $transaction->sampleStrategy($this->transactionSamplingStrategy);

        return $transaction;
    }

    /**
     * {@inheritdoc}
     */
    public function newSpan(string $name, EventBean $parent): Span
    {
        return new Span($name, $parent);
    }

    /**
     * {@inheritdoc}
     */
    public function newAsyncSpan(string $name, EventBean $parent): AsyncSpan
    {
        return new AsyncSpan($name, $parent);
    }

    /**
     * {@inheritdoc}
     */
    public function newMetricset(array $set, array $tags = []): Metricset
    {
        return new Metricset($set, $tags);
    }
}
