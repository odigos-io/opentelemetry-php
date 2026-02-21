<?php

namespace Illuminate\Database\Eloquent;

class SoftDeletingScope implements \Illuminate\Database\Eloquent\Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var string[]
     */
    protected $extensions = ['Restore', 'RestoreOrCreate', 'CreateOrRestore', 'WithTrashed', 'WithoutTrashed', 'OnlyTrashed'];
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @template TModel of \Illuminate\Database\Eloquent\Model
     *
     * @param  \Illuminate\Database\Eloquent\Builder<TModel>  $builder
     * @param  TModel  $model
     * @return void
     */
    public function apply(\Illuminate\Database\Eloquent\Builder $builder, \Illuminate\Database\Eloquent\Model $model)
    {
        $builder->whereNull($model->getQualifiedDeletedAtColumn());
    }
    /**
     * Extend the query builder with the needed functions.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<*>  $builder
     * @return void
     */
    public function extend(\Illuminate\Database\Eloquent\Builder $builder)
    {
        foreach ($this->extensions as $extension) {
            $this->{"add{$extension}"}($builder);
        }
        $builder->onDelete(function (\Illuminate\Database\Eloquent\Builder $builder) {
            $column = $this->getDeletedAtColumn($builder);
            return $builder->update([$column => $builder->getModel()->freshTimestampString()]);
        });
    }
    /**
     * Get the "deleted at" column for the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<*>  $builder
     * @return string
     */
    protected function getDeletedAtColumn(\Illuminate\Database\Eloquent\Builder $builder)
    {
        if (count((array) $builder->getQuery()->joins) > 0) {
            return $builder->getModel()->getQualifiedDeletedAtColumn();
        }
        return $builder->getModel()->getDeletedAtColumn();
    }
    /**
     * Add the restore extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<*>  $builder
     * @return void
     */
    protected function addRestore(\Illuminate\Database\Eloquent\Builder $builder)
    {
        $builder->macro('restore', function (\Illuminate\Database\Eloquent\Builder $builder) {
            $builder->withTrashed();
            return $builder->update([$builder->getModel()->getDeletedAtColumn() => null]);
        });
    }
    /**
     * Add the restore-or-create extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<*>  $builder
     * @return void
     */
    protected function addRestoreOrCreate(\Illuminate\Database\Eloquent\Builder $builder)
    {
        $builder->macro('restoreOrCreate', function (\Illuminate\Database\Eloquent\Builder $builder, array $attributes = [], array $values = []) {
            $builder->withTrashed();
            return tap($builder->firstOrCreate($attributes, $values), function ($instance) {
                $instance->restore();
            });
        });
    }
    /**
     * Add the create-or-restore extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<*>  $builder
     * @return void
     */
    protected function addCreateOrRestore(\Illuminate\Database\Eloquent\Builder $builder)
    {
        $builder->macro('createOrRestore', function (\Illuminate\Database\Eloquent\Builder $builder, array $attributes = [], array $values = []) {
            $builder->withTrashed();
            return tap($builder->createOrFirst($attributes, $values), function ($instance) {
                $instance->restore();
            });
        });
    }
    /**
     * Add the with-trashed extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<*>  $builder
     * @return void
     */
    protected function addWithTrashed(\Illuminate\Database\Eloquent\Builder $builder)
    {
        $builder->macro('withTrashed', function (\Illuminate\Database\Eloquent\Builder $builder, $withTrashed = \true) {
            if (!$withTrashed) {
                return $builder->withoutTrashed();
            }
            return $builder->withoutGlobalScope($this);
        });
    }
    /**
     * Add the without-trashed extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<*>  $builder
     * @return void
     */
    protected function addWithoutTrashed(\Illuminate\Database\Eloquent\Builder $builder)
    {
        $builder->macro('withoutTrashed', function (\Illuminate\Database\Eloquent\Builder $builder) {
            $model = $builder->getModel();
            $builder->withoutGlobalScope($this)->whereNull($model->getQualifiedDeletedAtColumn());
            return $builder;
        });
    }
    /**
     * Add the only-trashed extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<*>  $builder
     * @return void
     */
    protected function addOnlyTrashed(\Illuminate\Database\Eloquent\Builder $builder)
    {
        $builder->macro('onlyTrashed', function (\Illuminate\Database\Eloquent\Builder $builder) {
            $model = $builder->getModel();
            $builder->withoutGlobalScope($this)->whereNotNull($model->getQualifiedDeletedAtColumn());
            return $builder;
        });
    }
}
