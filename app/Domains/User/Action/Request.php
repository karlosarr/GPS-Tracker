<?php declare(strict_types=1);

namespace App\Domains\User\Action;

use App\Exceptions\AuthenticationException;

class Request extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->row();
        $this->check();
        $this->set();
    }

    /**
     * @return void
     */
    protected function row(): void
    {
        $this->row = $this->request->user();
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        if (empty($this->row)) {
            throw new AuthenticationException(__('user-auth.error.empty'));
        }
    }

    /**
     * @return void
     */
    protected function set(): void
    {
        $this->setRow();
        $this->setLanguage();
    }

    /**
     * @return void
     */
    protected function setRow(): void
    {
        app()->bind('user', fn () => $this->row);
    }

    /**
     * @return void
     */
    protected function setLanguage(): void
    {
        $this->factory('Language', $this->row->language)->action()->set();
    }
}
