<?php
declare(strict_types=1);
namespace Neos\ContentRepository\Projection;

use Neos\ContentRepository\CommandHandler\PendingProjections;
use Neos\ContentRepository\ContentRepository;
use Neos\EventStore\CatchUp\CheckpointStorageInterface;
use Neos\EventStore\Model\EventStream\EventStreamInterface;
use Neos\EventStore\Model\Event\SequenceNumber;
use Neos\EventStore\Model\Event;

/**
 * Common interface for a Content Repository projection. This API is NOT exposed to the outside world, but is
 * the contract between {@see ContentRepository} and the individual projections.
 *
 * @template TState of ProjectionStateInterface
 */
interface ProjectionInterface
{
    /**
     * Set up the projection state (create databases, call CheckpointStorage::setup()).
     */
    public function setUp(): void;

    /**
     * Can the projection handle this event? Must be deterministic.
     *
     * Used to determine whether this projection should be triggered in response to an event; and also
     * needed as part of the Blocking logic ({@see PendingProjections}).
     *
     * @param Event $event
     * @return bool
     */
    public function canHandle(Event $event): bool;

    /**
     * Catch up the projection, consuming the not-yet-seen events in the given event stream.
     *
     * How this is called depends a lot on your infrastructure - usually via some indirection
     * from {@see ProjectionCatchUpTriggerInterface}.
     *
     * @param EventStreamInterface $eventStream
     * @return void
     */
    public function catchUp(EventStreamInterface $eventStream): void;

    /**
     * Part of the Blocking implementation of commands - usually delegates to an internal
     * {@see CheckpointStorageInterface::getHighestAppliedSequenceNumber()}.
     *
     * See {@see PendingProjections} for implementation details.
     */
    public function getSequenceNumber(): SequenceNumber;

    /**
     * @return TState
     */
    public function getState(): ProjectionStateInterface;
    public function reset(): void;
}
