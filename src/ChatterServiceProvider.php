<?php

namespace Kdes70\Chatter;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;
use Kdes70\Chatter\Facades\Chatter;
use Kdes70\Chatter\Repositories\Conversation\ConversationRepository;
use Kdes70\Chatter\Services\ChatterService;

class ChatterServiceProvider extends ServiceProvider
{

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        Relation::morphMap(config('chatter.relation'));

        $this->publishes([
            $this->configPath()     => config_path('chatter.php'),
            $this->componentsPath() => base_path('resources/assets/js/components/chatter'),
        ], 'chatter');

        $this->loadRoutesFrom($this->routesPath());

        $this->loadViewsFrom($this->viewsPath(), 'chatter');

        $this->loadMigrationsFrom($this->migrationsPath());

        $this->registerBroadcast();

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom($this->configPath(), 'chatter');
        $this->registerFacade();
        $this->registerAlias();
        $this->registerChatter();

    }

    protected function registerBroadcast(): void
    {
        Broadcast::channel(
            $this->app['config']->get('chatter.channel.chat_room') . '-{conversationId}',
            function ($user, $conversationId) {
                if ($this->app['conversation.repository']->canJoinConversation($user, $conversationId)) {
                    return $user;
                }
            }
        );
    }

    protected function registerFacade(): void
    {
        $this->app->booting(function () {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Chatter', Chatter::class);
        });
    }

    protected function registerChatter(): void
    {
        $this->app->bind('chatter', function ($app) {
            $config = $app['config'];
            $conversation = $app['conversation.repository'];
            return new ChatterService($config, $conversation);
        });

    }

    protected function registerAlias(): void
    {
        $this->app->singleton('conversation.repository', function () {
            return new ConversationRepository();
        });
        $this->app->alias('conversation.repository', ConversationRepository::class);

    }

    /**
     * @return string
     */
    protected function viewsPath(): string
    {
        return __DIR__ . '/../resources/views/chatter';
    }


    /**
     * @return string
     */
    protected function configPath(): string
    {
        return __DIR__ . '/config/chatter.php';
    }

    /**
     * @return string
     */
    protected function componentsPath(): string
    {
        return __DIR__ . '/../resources/assets/js/components';
    }

    /**
     * @return string
     */
    protected function migrationsPath(): string
    {
        return __DIR__ . '/database/migrations';
    }

    /**
     * @return string
     */
    protected function routesPath(): string
    {
        return __DIR__ . '/Http/routes.php';
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [
            'conversation.repository',
        ];
    }
}


