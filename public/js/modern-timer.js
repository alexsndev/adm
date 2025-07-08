/**
 * Cronômetro Robusto - Não reinicia ao dar F5
 * Versão 2.0
 */

class RobustTimer {
    constructor(taskId, baseMinutes, startedAt, pausedAt, status) {
        this.taskId = taskId;
        this.baseSeconds = (parseInt(baseMinutes) || 0) * 60;
        this.startTime = startedAt ? new Date(startedAt) : null;
        this.pauseTime = pausedAt ? new Date(pausedAt) : null;
        this.isRunning = !pausedAt && startedAt;
        this.interval = null;
        this.autoSaveInterval = null;
        this.totalSeconds = 0;
        this.saveInterval = 30000; // Salvar a cada 30 segundos
        this.status = status;
        this.storageKey = `timer_${taskId}`;
        this.boundKeydown = this.handleKeydown.bind(this);
        this.boundBeforeUnload = this.handleBeforeUnload.bind(this);
        this.init();
    }
    
    init() {
        this.loadFromStorage();
        this.calculateTotalTime();
        this.setupEvents();
        this.updateDisplay();
        this.updateButtons();
        this.startTimer();
        this.startAutoSave();
        window.addEventListener('keydown', this.boundKeydown);
        window.addEventListener('beforeunload', this.boundBeforeUnload);
        
        console.log('🚀 Timer robusto iniciado:', {
            taskId: this.taskId,
            baseSeconds: this.baseSeconds,
            startTime: this.startTime,
            isRunning: this.isRunning,
            totalSeconds: this.totalSeconds
        });
    }
    
    loadFromStorage() {
        try {
            const saved = localStorage.getItem(this.storageKey);
            if (saved) {
                const data = JSON.parse(saved);
                if (typeof data.baseSeconds === 'number') {
                    this.baseSeconds = data.baseSeconds;
                }
                if (data.isRunning && data.startTime) {
                    const now = new Date();
                    const startTime = new Date(data.startTime);
                    const elapsedSeconds = Math.floor((now - startTime) / 1000);
                    this.totalSeconds = this.baseSeconds + elapsedSeconds;
                    this.startTime = startTime;
                    this.isRunning = true;
                } else {
                    this.totalSeconds = this.baseSeconds;
                    this.isRunning = false;
                }
            }
        } catch (error) {
            console.error('Erro ao carregar do localStorage:', error);
        }
    }
    
    saveToStorage() {
        try {
            const data = {
                baseSeconds: this.baseSeconds,
                totalSeconds: this.totalSeconds,
                isRunning: this.isRunning,
                startTime: this.startTime ? this.startTime.toISOString() : null,
                lastSave: Date.now()
            };
            localStorage.setItem(this.storageKey, JSON.stringify(data));
        } catch (error) {
            console.error('Erro ao salvar no localStorage:', error);
        }
    }
    
    calculateTotalTime() {
        if (this.isRunning && this.startTime) {
            const now = new Date();
            const elapsedSeconds = Math.max(0, Math.floor((now - this.startTime) / 1000));
            this.totalSeconds = this.baseSeconds + elapsedSeconds;
        } else {
            this.totalSeconds = this.baseSeconds;
        }
    }
    
    startTimer() {
        if (this.interval) {
            clearInterval(this.interval);
        }
        
        this.interval = setInterval(() => {
            if (this.isRunning) {
                this.totalSeconds++;
                this.updateDisplay();
            }
        }, 1000);
    }
    
    startAutoSave() {
        if (this.autoSaveInterval) {
            clearInterval(this.autoSaveInterval);
        }
        this.autoSaveInterval = setInterval(() => {
            if (this.isRunning) {
                this.saveToStorage();
                this.saveToServer();
            }
        }, this.saveInterval);
    }
    
    saveToServer() {
        const currentMinutes = Math.floor(this.totalSeconds / 60);
        let url;
        if (String(this.taskId).startsWith('project_')) {
            const projectId = String(this.taskId).replace('project_', '');
            url = `/projetos/${projectId}/update-time`;
        } else {
            url = `/tarefas-domesticas/${this.taskId}/update-time`;
        }
        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                actual_minutes: currentMinutes
            })
        }).then(() => {
            console.log('✅ Tempo salvo no servidor:', currentMinutes, 'minutos');
        }).catch(error => {
            console.error('❌ Erro ao salvar no servidor:', error);
        });
    }
    
    updateDisplay() {
        const hours = Math.floor(this.totalSeconds / 3600);
        const minutes = Math.floor((this.totalSeconds % 3600) / 60);
        const seconds = this.totalSeconds % 60;
        
        const hoursElement = document.getElementById('timer-hours');
        const minutesElement = document.getElementById('timer-minutes');
        const secondsElement = document.getElementById('timer-seconds');
        
        if (hoursElement) hoursElement.textContent = hours.toString().padStart(2, '0');
        if (minutesElement) minutesElement.textContent = minutes.toString().padStart(2, '0');
        if (secondsElement) secondsElement.textContent = seconds.toString().padStart(2, '0');
    }
    
    updateButtons() {
        const startBtn = document.getElementById('start-timer');
        const pauseBtn = document.getElementById('pause-timer');
        const statusText = document.getElementById('status-text');
        
        if (this.isRunning) {
            if (startBtn) startBtn.style.display = 'none';
            if (pauseBtn) pauseBtn.style.display = 'inline-block';
            if (statusText) {
                statusText.textContent = '⏱️ Executando';
                statusText.className = 'text-green-600 font-medium';
            }
        } else {
            if (startBtn) startBtn.style.display = 'inline-block';
            if (pauseBtn) pauseBtn.style.display = 'none';
            if (statusText) {
                statusText.textContent = '⏸️ Pausado';
                statusText.className = 'text-yellow-600 font-medium';
            }
        }
    }
    
    setupEvents() {
        const startBtn = document.getElementById('start-timer');
        const pauseBtn = document.getElementById('pause-timer');
        const resetBtn = document.getElementById('reset-timer');
        
        if (startBtn) {
            startBtn.onclick = (e) => {
                e.preventDefault();
                this.resume();
            };
        }
        
        if (pauseBtn) {
            pauseBtn.onclick = (e) => {
                e.preventDefault();
                this.pause();
            };
        }
        
        if (resetBtn) {
            resetBtn.onclick = (e) => {
                e.preventDefault();
                this.reset();
            };
        }
    }
    
    handleKeydown(e) {
        if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') return;
        if (e.code === 'Space') {
            e.preventDefault();
            if (this.isRunning) {
                this.pause();
            } else {
                this.resume();
            }
        }
    }
    
    handleBeforeUnload() {
        this.saveToStorage();
        if (this.isRunning) {
            this.saveToServer();
        }
    }
    
    pause() {
        console.log('⏸️ Pausando timer...');
        this.isRunning = false;
        this.pauseTime = new Date();
        this.baseSeconds = this.totalSeconds;
        this.updateButtons();
        this.saveToStorage();
        this.savePause();
    }
    
    resume() {
        console.log('▶️ Retomando timer...');
        this.isRunning = true;
        this.startTime = new Date();
        this.pauseTime = null;
        this.updateButtons();
        this.saveToStorage();
        this.saveResume();
    }
    
    reset() {
        if (confirm('🔄 Tem certeza que deseja reiniciar o cronômetro?')) {
            console.log('🔄 Reiniciando timer...');
            this.totalSeconds = 0;
            this.baseSeconds = 0;
            this.startTime = new Date();
            this.pauseTime = null;
            this.isRunning = true;
            this.updateDisplay();
            this.updateButtons();
            this.saveToStorage();
            this.saveReset();
        }
    }
    
    savePause() {
        let url;
        if (String(this.taskId).startsWith('project_')) {
            const projectId = String(this.taskId).replace('project_', '');
            url = `/projetos/${projectId}/pause-timer`;
        } else {
            url = `/tarefas-domesticas/${this.taskId}/pause`;
        }
        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        });
    }
    
    saveResume() {
        let url;
        if (String(this.taskId).startsWith('project_')) {
            const projectId = String(this.taskId).replace('project_', '');
            url = `/projetos/${projectId}/resume-timer`;
        } else {
            url = `/tarefas-domesticas/${this.taskId}/resume`;
        }
        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        });
    }
    
    saveReset() {
        let url;
        if (String(this.taskId).startsWith('project_')) {
            const projectId = String(this.taskId).replace('project_', '');
            url = `/projetos/${projectId}/reset-timer`;
        } else {
            url = `/tarefas-domesticas/${this.taskId}/reset-timer`;
        }
        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        }).then(() => {
            localStorage.removeItem(this.storageKey);
        });
    }
    
    stop() {
        this.isRunning = false;
        this.saveToStorage();
        if (this.interval) {
            clearInterval(this.interval);
            this.interval = null;
        }
        if (this.autoSaveInterval) {
            clearInterval(this.autoSaveInterval);
            this.autoSaveInterval = null;
        }
        window.removeEventListener('keydown', this.boundKeydown);
        window.removeEventListener('beforeunload', this.boundBeforeUnload);
    }
    
    destroy() {
        this.stop();
        localStorage.removeItem(this.storageKey);
    }
}

window.initModernTimer = function(taskId, baseMinutes, startedAt, pausedAt, status) {
    if (status !== 'in_progress') return null;
    return new RobustTimer(taskId, baseMinutes, startedAt, pausedAt, status);
};

window.stopCurrentTimer = function(taskId) {
    if (window.currentTimer) {
        window.currentTimer.stop();
    }
};

window.destroyCurrentTimer = function(taskId) {
    if (window.currentTimer) {
        window.currentTimer.destroy();
        window.currentTimer = null;
    }
};

console.log('✅ Robust Timer v2.0 carregado com sucesso!');