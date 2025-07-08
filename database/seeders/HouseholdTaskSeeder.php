<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HouseholdTask;
use App\Models\TaskCategory;
use App\Models\User;
use Carbon\Carbon;

class HouseholdTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        
        if (!$user) {
            $this->command->error('Nenhum usuário encontrado. Execute o UserSeeder primeiro.');
            return;
        }

        // Criar categorias de exemplo
        $categories = [
            [
                'name' => 'Limpeza',
                'color' => '#3B82F6',
                'icon' => 'fas fa-broom',
                'description' => 'Tarefas de limpeza da casa',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'Cozinha',
                'color' => '#EF4444',
                'icon' => 'fas fa-utensils',
                'description' => 'Tarefas relacionadas à cozinha',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => 'Lavanderia',
                'color' => '#8B5CF6',
                'icon' => 'fas fa-tshirt',
                'description' => 'Tarefas de lavagem e organização de roupas',
                'is_active' => true,
                'order' => 3,
            ],
            [
                'name' => 'Manutenção',
                'color' => '#F59E0B',
                'icon' => 'fas fa-tools',
                'description' => 'Tarefas de manutenção e reparos',
                'is_active' => true,
                'order' => 4,
            ],
            [
                'name' => 'Organização',
                'color' => '#10B981',
                'icon' => 'fas fa-boxes',
                'description' => 'Tarefas de organização e arrumação',
                'is_active' => true,
                'order' => 5,
            ],
        ];

        foreach ($categories as $categoryData) {
            TaskCategory::create([
                'user_id' => $user->id,
                ...$categoryData,
            ]);
        }

        $categories = TaskCategory::where('user_id', $user->id)->get();

        // Criar tarefas de exemplo
        $tasks = [
            // Limpeza
            [
                'task_category_id' => $categories->where('name', 'Limpeza')->first()->id,
                'title' => 'Limpar o banheiro',
                'description' => 'Limpar pia, chuveiro, vaso sanitário e espelho',
                'status' => 'pending',
                'priority' => 'medium',
                'assigned_to' => 'both',
                'frequency' => 'weekly',
                'due_date' => Carbon::today()->addDays(2),
                'due_time' => '09:00',
                'estimated_minutes' => 30,
                'notes' => 'Usar produtos de limpeza específicos para banheiro',
                'is_recurring' => true,
            ],
            [
                'task_category_id' => $categories->where('name', 'Limpeza')->first()->id,
                'title' => 'Aspirar a casa',
                'description' => 'Aspirar todos os cômodos da casa',
                'status' => 'completed',
                'priority' => 'low',
                'assigned_to' => 'alexandre',
                'frequency' => 'weekly',
                'due_date' => Carbon::today()->subDays(1),
                'due_time' => '14:00',
                'estimated_minutes' => 45,
                'notes' => 'Não esquecer de aspirar debaixo dos móveis',
                'is_recurring' => true,
                'completed_date' => Carbon::today()->subDays(1),
                'actual_minutes' => 40,
            ],
            [
                'task_category_id' => $categories->where('name', 'Limpeza')->first()->id,
                'title' => 'Limpar a cozinha',
                'description' => 'Limpar fogão, geladeira e bancadas',
                'status' => 'in_progress',
                'priority' => 'high',
                'assigned_to' => 'liza',
                'frequency' => 'daily',
                'due_date' => Carbon::today(),
                'due_time' => '18:00',
                'estimated_minutes' => 20,
                'notes' => 'Limpar após o jantar',
                'is_recurring' => true,
            ],

            // Cozinha
            [
                'task_category_id' => $categories->where('name', 'Cozinha')->first()->id,
                'title' => 'Fazer compras do mês',
                'description' => 'Comprar alimentos e produtos de limpeza',
                'status' => 'pending',
                'priority' => 'urgent',
                'assigned_to' => 'both',
                'frequency' => 'monthly',
                'due_date' => Carbon::today()->addDays(1),
                'due_time' => '10:00',
                'estimated_minutes' => 120,
                'notes' => 'Fazer lista antes de sair',
                'is_recurring' => true,
            ],
            [
                'task_category_id' => $categories->where('name', 'Cozinha')->first()->id,
                'title' => 'Organizar a despensa',
                'description' => 'Verificar validades e reorganizar produtos',
                'status' => 'pending',
                'priority' => 'medium',
                'assigned_to' => 'liza',
                'frequency' => 'weekly',
                'due_date' => Carbon::today()->addDays(3),
                'due_time' => '15:00',
                'estimated_minutes' => 60,
                'notes' => 'Separar produtos vencidos',
                'is_recurring' => true,
            ],

            // Lavanderia
            [
                'task_category_id' => $categories->where('name', 'Lavanderia')->first()->id,
                'title' => 'Lavar roupas',
                'description' => 'Lavar, secar e passar roupas da semana',
                'status' => 'pending',
                'priority' => 'high',
                'assigned_to' => 'both',
                'frequency' => 'weekly',
                'due_date' => Carbon::today()->addDays(1),
                'due_time' => '08:00',
                'estimated_minutes' => 90,
                'notes' => 'Separar por cor e tipo de tecido',
                'is_recurring' => true,
            ],
            [
                'task_category_id' => $categories->where('name', 'Lavanderia')->first()->id,
                'title' => 'Dobrar e guardar roupas',
                'description' => 'Organizar roupas limpas no guarda-roupa',
                'status' => 'pending',
                'priority' => 'low',
                'assigned_to' => 'alexandre',
                'frequency' => 'weekly',
                'due_date' => Carbon::today()->addDays(2),
                'due_time' => '20:00',
                'estimated_minutes' => 30,
                'notes' => 'Fazer após lavar as roupas',
                'is_recurring' => true,
            ],

            // Manutenção
            [
                'task_category_id' => $categories->where('name', 'Manutenção')->first()->id,
                'title' => 'Trocar lâmpada da sala',
                'description' => 'Comprar e instalar nova lâmpada',
                'status' => 'pending',
                'priority' => 'medium',
                'assigned_to' => 'alexandre',
                'frequency' => 'once',
                'due_date' => Carbon::today()->addDays(5),
                'estimated_minutes' => 15,
                'notes' => 'Verificar o tipo de lâmpada necessária',
                'is_recurring' => false,
            ],
            [
                'task_category_id' => $categories->where('name', 'Manutenção')->first()->id,
                'title' => 'Verificar filtros do ar condicionado',
                'description' => 'Limpar ou trocar filtros dos aparelhos',
                'status' => 'pending',
                'priority' => 'low',
                'assigned_to' => 'alexandre',
                'frequency' => 'monthly',
                'due_date' => Carbon::today()->addDays(7),
                'estimated_minutes' => 45,
                'notes' => 'Fazer antes do verão',
                'is_recurring' => true,
            ],

            // Organização
            [
                'task_category_id' => $categories->where('name', 'Organização')->first()->id,
                'title' => 'Organizar documentos',
                'description' => 'Separar e arquivar documentos importantes',
                'status' => 'pending',
                'priority' => 'medium',
                'assigned_to' => 'both',
                'frequency' => 'monthly',
                'due_date' => Carbon::today()->addDays(4),
                'due_time' => '16:00',
                'estimated_minutes' => 60,
                'notes' => 'Usar pastas organizadoras',
                'is_recurring' => true,
            ],
            [
                'task_category_id' => $categories->where('name', 'Organização')->first()->id,
                'title' => 'Limpar armários',
                'description' => 'Organizar e limpar armários da casa',
                'status' => 'pending',
                'priority' => 'low',
                'assigned_to' => 'liza',
                'frequency' => 'monthly',
                'due_date' => Carbon::today()->addDays(10),
                'estimated_minutes' => 120,
                'notes' => 'Fazer um armário por vez',
                'is_recurring' => true,
            ],
        ];

        foreach ($tasks as $taskData) {
            HouseholdTask::create([
                'user_id' => $user->id,
                'order' => HouseholdTask::where('user_id', $user->id)->max('order') + 1,
                ...$taskData,
            ]);
        }

        $this->command->info('Tarefas domésticas de exemplo criadas com sucesso!');
    }
} 