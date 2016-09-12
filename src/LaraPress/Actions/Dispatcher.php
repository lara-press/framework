<?php

namespace LaraPress\Actions;

use Illuminate\Events\Dispatcher as EventsDispatcher;

class Dispatcher extends EventsDispatcher {

    protected $registeredWpActions = [];

    /**
     * Register an event listener with the dispatcher.
     *
     * @param  string|array $events
     * @param  mixed        $listener
     * @param  int          $priority
     *
     * @param int           $acceptedArgs
     */
    public function listen($events, $listener, $priority = 0, $acceptedArgs = 1)
    {
        foreach ((array)$events as $event)
        {
            $this->listeners[$event][$priority][] = $this->makeListener($listener);

            unset($this->sorted[$event]);

            if ( ! isset($this->registeredWpActions[$event]))
            {
                $this->registeredWpActions[$event] = true;

                add_action(
                    $event,
                    function () use ($event)
                    {
                        return $this->fire($event, func_get_args());
                    },
                    $priority,
                    $acceptedArgs
                );
            }
        }
    }
}
