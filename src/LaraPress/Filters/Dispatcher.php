<?php namespace LaraPress\Filters;

use Illuminate\Events\Dispatcher as EventsDispatcher;

class Dispatcher extends EventsDispatcher {

    protected $registeredWpFilters = [];

    /**
     * Register an event listener with the dispatcher.
     *
     * @param  string|array $events
     * @param  mixed        $listener
     * @param  int          $priority
     * @param int           $acceptedArgs
     */
    public function listen($events, $listener, $priority = 10, $acceptedArgs = 1)
    {
        foreach ((array)$events as $filter)
        {
            $this->listeners[$filter][$priority][] = $this->makeListener($listener);

            unset($this->sorted[$filter]);

            if ( ! isset($this->registeredWpFilters[$filter]))
            {
                $this->registeredWpFilters[$filter] = true;

                add_filter(
                    $filter,
                    function () use ($filter)
                    {
                        return $this->fire($filter, func_get_args());
                    },
                    $priority,
                    $acceptedArgs
                );
            }
        }
    }

    /**
     * Fire an event and call the listeners.
     *
     * @param  string|object $event
     * @param  mixed         $payload
     * @param  bool          $halt
     *
     * @return array|null
     */
    public function fire($event, $payload = [], $halt = false)
    {
        $this->firing[] = $event;

        foreach ($this->getListeners($event) as $listener)
        {
            $payload = call_user_func_array($listener, (array) $payload);
        }

        array_pop($this->firing);

        return $payload;
    }
}
