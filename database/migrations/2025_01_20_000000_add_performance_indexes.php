<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Índices para transações
        if (Schema::hasTable('transactions')) {
            Schema::table('transactions', function (Blueprint $table) {
                if (!$this->indexExists('transactions', 'transactions_user_id_date_index')) {
                    $table->index(['user_id', 'date']);
                }
                if (!$this->indexExists('transactions', 'transactions_user_id_type_date_index')) {
                    $table->index(['user_id', 'type', 'date']);
                }
                if (!$this->indexExists('transactions', 'transactions_user_id_category_id_index')) {
                    $table->index(['user_id', 'category_id']);
                }
                if (!$this->indexExists('transactions', 'transactions_user_id_account_id_index')) {
                    $table->index(['user_id', 'account_id']);
                }
                if (!$this->indexExists('transactions', 'transactions_date_type_index')) {
                    $table->index(['date', 'type']);
                }
            });
        }

        // Índices para contas
        if (Schema::hasTable('accounts')) {
            Schema::table('accounts', function (Blueprint $table) {
                if (!$this->indexExists('accounts', 'accounts_user_id_is_active_index')) {
                    $table->index(['user_id', 'is_active']);
                }
                if (!$this->indexExists('accounts', 'accounts_user_id_type_index')) {
                    $table->index(['user_id', 'type']);
                }
            });
        }

        // Índices para eventos
        if (Schema::hasTable('events')) {
            Schema::table('events', function (Blueprint $table) {
                if (!$this->indexExists('events', 'events_user_id_is_active_index')) {
                    $table->index(['user_id', 'is_active']);
                }
                if (!$this->indexExists('events', 'events_user_id_type_index')) {
                    $table->index(['user_id', 'type']);
                }
            });
        }

        // Índices para ocorrências de eventos
        if (Schema::hasTable('event_occurrences')) {
            Schema::table('event_occurrences', function (Blueprint $table) {
                if (!$this->indexExists('event_occurrences', 'event_occurrences_occurrence_date_occurrence_time_index')) {
                    $table->index(['occurrence_date', 'occurrence_time']);
                }
                if (!$this->indexExists('event_occurrences', 'event_occurrences_event_id_occurrence_date_index')) {
                    $table->index(['event_id', 'occurrence_date']);
                }
            });
        }

        // Índices para dívidas
        if (Schema::hasTable('debts')) {
            Schema::table('debts', function (Blueprint $table) {
                if (!$this->indexExists('debts', 'debts_user_id_status_index')) {
                    $table->index(['user_id', 'status']);
                }
                if (!$this->indexExists('debts', 'debts_user_id_due_date_index')) {
                    $table->index(['user_id', 'due_date']);
                }
            });
        }

        // Índices para metas financeiras
        if (Schema::hasTable('financial_goals')) {
            Schema::table('financial_goals', function (Blueprint $table) {
                if (!$this->indexExists('financial_goals', 'financial_goals_user_id_status_index')) {
                    $table->index(['user_id', 'status']);
                }
                if (!$this->indexExists('financial_goals', 'financial_goals_user_id_target_date_index')) {
                    $table->index(['user_id', 'target_date']);
                }
            });
        }

        // Índices para projetos
        if (Schema::hasTable('projects')) {
            Schema::table('projects', function (Blueprint $table) {
                if (!$this->indexExists('projects', 'projects_user_id_status_index')) {
                    $table->index(['user_id', 'status']);
                }
                if (!$this->indexExists('projects', 'projects_user_id_priority_index')) {
                    $table->index(['user_id', 'priority']);
                }
                if (!$this->indexExists('projects', 'projects_client_id_status_index')) {
                    $table->index(['client_id', 'status']);
                }
            });
        }

        // Índices para tarefas
        if (Schema::hasTable('tasks')) {
            Schema::table('tasks', function (Blueprint $table) {
                if (!$this->indexExists('tasks', 'tasks_user_id_status_index')) {
                    $table->index(['user_id', 'status']);
                }
                if (!$this->indexExists('tasks', 'tasks_user_id_due_date_index')) {
                    $table->index(['user_id', 'due_date']);
                }
                if (!$this->indexExists('tasks', 'tasks_project_id_status_index')) {
                    $table->index(['project_id', 'status']);
                }
            });
        }

        // Índices para tarefas domésticas
        if (Schema::hasTable('household_tasks')) {
            Schema::table('household_tasks', function (Blueprint $table) {
                if (!$this->indexExists('household_tasks', 'household_tasks_user_id_status_index')) {
                    $table->index(['user_id', 'status']);
                }
                if (!$this->indexExists('household_tasks', 'household_tasks_user_id_due_date_index')) {
                    $table->index(['user_id', 'due_date']);
                }
                // Verificar se a coluna category_id existe antes de criar o índice
                if (Schema::hasColumn('household_tasks', 'category_id') && !$this->indexExists('household_tasks', 'household_tasks_category_id_status_index')) {
                    $table->index(['category_id', 'status']);
                }
            });
        }

        // Índices para categorias
        if (Schema::hasTable('categories')) {
            Schema::table('categories', function (Blueprint $table) {
                if (!$this->indexExists('categories', 'categories_user_id_type_index')) {
                    $table->index(['user_id', 'type']);
                }
            });
        }

        // Índices para cartões de crédito
        if (Schema::hasTable('credit_cards')) {
            Schema::table('credit_cards', function (Blueprint $table) {
                if (!$this->indexExists('credit_cards', 'credit_cards_user_id_is_active_index')) {
                    $table->index(['user_id', 'is_active']);
                }
            });
        }

        // Índices para usuários
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (!$this->indexExists('users', 'users_is_admin_index')) {
                    $table->index(['is_admin']);
                }
                if (!$this->indexExists('users', 'users_is_client_index')) {
                    $table->index(['is_client']);
                }
                if (!$this->indexExists('users', 'users_email_index')) {
                    $table->index(['email']);
                }
            });
        }
    }

    public function down(): void
    {
        // Remover índices de transações
        if (Schema::hasTable('transactions')) {
            Schema::table('transactions', function (Blueprint $table) {
                $table->dropIndexIfExists(['user_id', 'date']);
                $table->dropIndexIfExists(['user_id', 'type', 'date']);
                $table->dropIndexIfExists(['user_id', 'category_id']);
                $table->dropIndexIfExists(['user_id', 'account_id']);
                $table->dropIndexIfExists(['date', 'type']);
            });
        }

        // Remover índices de contas
        if (Schema::hasTable('accounts')) {
            Schema::table('accounts', function (Blueprint $table) {
                $table->dropIndexIfExists(['user_id', 'is_active']);
                $table->dropIndexIfExists(['user_id', 'type']);
            });
        }

        // Remover índices de eventos
        if (Schema::hasTable('events')) {
            Schema::table('events', function (Blueprint $table) {
                $table->dropIndexIfExists(['user_id', 'is_active']);
                $table->dropIndexIfExists(['user_id', 'type']);
            });
        }

        // Remover índices de ocorrências
        if (Schema::hasTable('event_occurrences')) {
            Schema::table('event_occurrences', function (Blueprint $table) {
                $table->dropIndexIfExists(['occurrence_date', 'occurrence_time']);
                $table->dropIndexIfExists(['event_id', 'occurrence_date']);
            });
        }

        // Remover índices de dívidas
        if (Schema::hasTable('debts')) {
            Schema::table('debts', function (Blueprint $table) {
                $table->dropIndexIfExists(['user_id', 'status']);
                $table->dropIndexIfExists(['user_id', 'due_date']);
            });
        }

        // Remover índices de metas
        if (Schema::hasTable('financial_goals')) {
            Schema::table('financial_goals', function (Blueprint $table) {
                $table->dropIndexIfExists(['user_id', 'status']);
                $table->dropIndexIfExists(['user_id', 'target_date']);
            });
        }

        // Remover índices de projetos
        if (Schema::hasTable('projects')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->dropIndexIfExists(['user_id', 'status']);
                $table->dropIndexIfExists(['user_id', 'priority']);
                $table->dropIndexIfExists(['client_id', 'status']);
            });
        }

        // Remover índices de tarefas
        if (Schema::hasTable('tasks')) {
            Schema::table('tasks', function (Blueprint $table) {
                $table->dropIndexIfExists(['user_id', 'status']);
                $table->dropIndexIfExists(['user_id', 'due_date']);
                $table->dropIndexIfExists(['project_id', 'status']);
            });
        }

        // Remover índices de tarefas domésticas
        if (Schema::hasTable('household_tasks')) {
            Schema::table('household_tasks', function (Blueprint $table) {
                $table->dropIndexIfExists(['user_id', 'status']);
                $table->dropIndexIfExists(['user_id', 'due_date']);
                $table->dropIndexIfExists(['category_id', 'status']);
            });
        }

        // Remover índices de categorias
        if (Schema::hasTable('categories')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->dropIndexIfExists(['user_id', 'type']);
            });
        }

        // Remover índices de cartões
        if (Schema::hasTable('credit_cards')) {
            Schema::table('credit_cards', function (Blueprint $table) {
                $table->dropIndexIfExists(['user_id', 'is_active']);
            });
        }

        // Remover índices de usuários
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropIndexIfExists(['is_admin']);
                $table->dropIndexIfExists(['is_client']);
                $table->dropIndexIfExists(['email']);
            });
        }
    }

    private function indexExists(string $table, string $indexName): bool
    {
        try {
            $indexes = DB::select("SHOW INDEX FROM {$table}");
            return collect($indexes)->contains('Key_name', $indexName);
        } catch (\Exception $e) {
            return false;
        }
    }
}; 