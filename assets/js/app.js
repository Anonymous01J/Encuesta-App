// Objeto para manejar el estado de la aplicación
const AppState = {
    surveys: [],
    currentSurvey: null,
    modal: null,
    offcanvas: null
};

// Elementos DOM
const DOM = {
    surveyList: document.getElementById('survey-list'),
    modalContent: document.getElementById('modalContent'),
    pageLoader: document.getElementById('pageLoader'),
    toastContainer: document.getElementById('toastContainer'),
    refreshBtn: document.getElementById('refreshBtn')
};

// Inicializar la aplicación
function initApp() {
    // Inicializar componentes de Bootstrap
    AppState.modal = new bootstrap.Modal(document.getElementById('surveyModal'));
    AppState.offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasMenu'));
    
    // Cargar encuestas al inicio
    loadSurveys();
    
    // Event listeners
    DOM.refreshBtn.addEventListener('click', loadSurveys);
}

// Mostrar loader
function showLoader() {
    DOM.pageLoader.style.display = 'flex';
}

// Ocultar loader
function hideLoader() {
    DOM.pageLoader.style.display = 'none';
}

// Mostrar toast de notificación
function showToast(message, type = 'success') {
    const toastId = 'toast-' + Date.now();
    const bgClass = type === 'success' ? 'bg-success' : 'bg-danger';
    
    const toastEl = document.createElement('div');
    toastEl.className = `toast align-items-center text-white ${bgClass} border-0`;
    toastEl.setAttribute('role', 'alert');
    toastEl.setAttribute('aria-live', 'assertive');
    toastEl.setAttribute('aria-atomic', 'true');
    toastEl.id = toastId;
    
    toastEl.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi ${type === 'success' ? 'bi-check-circle' : 'bi-exclamation-triangle'} me-2"></i>
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    `;
    
    DOM.toastContainer.appendChild(toastEl);
    
    // Inicializar y mostrar el toast
    const toast = new bootstrap.Toast(toastEl);
    toast.show();
    
    // Eliminar el toast después de que se oculte
    toastEl.addEventListener('hidden.bs.toast', () => {
        toastEl.remove();
    });
}

// Cargar encuestas desde el servidor
function loadSurveys() {
    showLoader();
    
    fetch('?c=CHome/getEncuestas')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al cargar encuestas');
            }
            return response.json();
        })
        .then(data => {
            AppState.surveys = data;
            renderSurveys();
            hideLoader();
            showToast('Encuestas actualizadas correctamente');
        })
        .catch(error => {
            hideLoader();
            showToast('Error al cargar encuestas', 'error');
            console.error('Error:', error);
        });
}

// Renderizar encuestas en la lista
function renderSurveys() {
    DOM.surveyList.innerHTML = '';
    
    if (AppState.surveys.length === 0) {
        DOM.surveyList.innerHTML = `
            <div class="col-12 text-center py-5">
                <i class="bi bi-clipboard-x display-4 text-muted"></i>
                <h4 class="mt-3">No hay encuestas disponibles</h4>
                <p class="text-muted">Actualmente no hay encuestas activas para responder</p>
            </div>
        `;
        return;
    }
    
    AppState.surveys.forEach(survey => {
        const badgeClass = 
            survey.tipo === 'SUS' ? 'bg-success' : 
            survey.tipo === 'NPS' ? 'bg-primary' : 'bg-info';
        
        const surveyCard = document.createElement('div');
        surveyCard.className = 'col-12 mb-3';
        surveyCard.innerHTML = `
            <div class="card survey-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <span class="badge ${badgeClass} me-2">${survey.tipo}</span>
                            <h5 class="card-title d-inline">${survey.nombre}</h5>
                        </div>
                        <div class="text-muted small">
                            <i class="bi bi-people"></i> ${survey.respuestas || 0}
                        </div>
                    </div>
                    <p class="card-text text-muted mt-2">${survey.descripcion}</p>
                    <div class="d-grid mt-3">
                        <button class="btn btn-primary btn-responder" data-id="${survey.id}">
                            <i class="bi bi-pencil-square me-1"></i> Responder
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        DOM.surveyList.appendChild(surveyCard);
    });
    
    // Agregar event listeners a los botones de responder
    document.querySelectorAll('.btn-responder').forEach(button => {
        button.addEventListener('click', function() {
            const surveyId = this.getAttribute('data-id');
            loadSurveyDetails(surveyId);
        });
    });
}

// Cargar detalles de una encuesta específica
function loadSurveyDetails(surveyId) {
    showLoader();
    
    fetch(`?c=CHome/getEncuesta&id=${surveyId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Encuesta no encontrada');
            }
            return response.json();
        })
        .then(data => {
            AppState.currentSurvey = {
                id: data.encuesta.id,
                nombre: data.encuesta.nombre,
                tipo: data.encuesta.tipo,
                descripcion: data.encuesta.descripcion,
                respuestas: data.encuesta.respuestas || 0,
                preguntas: data.preguntas.map(p => ({
                    id: p.id,
                    texto: p.texto,
                    tipo_respuesta: p.tipo_respuesta,
                    opciones: p.opciones || [],
                    placeholder: p.tipo_respuesta === 'texto_libre' 
                        ? "¿Tiene alguna sugerencia?" 
                        : null
                }))
            };
            
            renderSurveyModal();
            AppState.modal.show();
            hideLoader();
        })
        .catch(error => {
            hideLoader();
            showToast('Encuesta no encontrada', 'error');
            console.error('Error:', error);
        });
}

// Renderizar el modal de la encuesta
function renderSurveyModal() {
    if (!AppState.currentSurvey) return;
    
    const survey = AppState.currentSurvey;
    
    let modalHtml = `
        <div class="modal-header">
            <h5 class="modal-title">${survey.nombre}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p class="text-muted">${survey.descripcion}</p>
            <form id="surveyForm">
    `;
    
    survey.preguntas.forEach((pregunta, index) => {
        modalHtml += `
            <div class="question-item mb-4">
                <div class="d-flex justify-content-between mb-2">
                    <h6>${index + 1}. ${pregunta.texto}</h6>
                    ${pregunta.required ? '<small class="text-danger">* Requerido</small>' : ''}
                </div>
        `;
        
        if (pregunta.tipo_respuesta === 'texto_libre') {
            modalHtml += `
                <textarea class="form-control" 
                        name="pregunta-${pregunta.id}" 
                        placeholder="${pregunta.placeholder || 'Escribe tu respuesta aquí'}"
                        ${pregunta.required ? 'required' : ''}></textarea>
            `;
        } else {
            modalHtml += '<div class="response-options">';
            
            (pregunta.opciones || []).forEach((opcion, idx) => {
                modalHtml += `
                    <div class="response-option" 
                        onclick="selectOption(this, 'pregunta-${pregunta.id}')">
                        <input type="radio" 
                            class="form-check-input" 
                            name="pregunta-${pregunta.id}" 
                            id="q${pregunta.id}o${idx}" 
                            value="${opcion.id}"
                            ${pregunta.required ? 'required' : ''}>
                        <label class="form-check-label ms-2" for="q${pregunta.id}o${idx}">
                            ${opcion.valor}
                        </label>
                    </div>
                `;
            });
            
            modalHtml += '</div>';
        }
        
        modalHtml += '</div>';
    });
    
    modalHtml += `
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" id="submitSurveyBtn">Enviar Respuesta</button>
        </div>
    `;
    
    DOM.modalContent.innerHTML = modalHtml;
    
    // Agregar event listener al botón de enviar dentro del modal
    document.getElementById('submitSurveyBtn').addEventListener('click', submitSurvey);
}

// Función global para seleccionar opciones
function selectOption(element, questionName) {
    const container = element.closest('.response-options');
    if (container) {
        container.querySelectorAll('.response-option').forEach(opt => {
            opt.classList.remove('selected');
        });
        element.classList.add('selected');
        
        const radio = element.querySelector('input[type="radio"]');
        if (radio) {
            radio.checked = true;
        }
    }
}

// Enviar las respuestas de la encuesta
function submitSurvey() {
    const form = document.getElementById('surveyForm');
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }
    
    showLoader();
    
    // Construir payload
    const respuestas = [];
    
    AppState.currentSurvey.preguntas.forEach(pregunta => {
        const input = form.querySelector(`[name="pregunta-${pregunta.id}"]`);
        
        if (pregunta.tipo_respuesta === 'texto_libre') {
            respuestas.push({
                pregunta_id: pregunta.id,
                texto: input.value
            });
        } else {
            respuestas.push({
                pregunta_id: pregunta.id,
                opcion_id: input.value
            });
        }
    });
    
    // Enviar al backend
    fetch('?c=CHome/saveRespuesta', {
        method: 'POST',
        headers: { 
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ respuestas })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en el servidor');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            AppState.modal.hide();
            hideLoader();
            showToast('¡Gracias por responder la encuesta!');
            
            // Actualizar contador de respuestas localmente
            const surveyIndex = AppState.surveys.findIndex(s => s.id === AppState.currentSurvey.id);
            if (surveyIndex !== -1) {
                AppState.surveys[surveyIndex].respuestas += 1;
                renderSurveys();
            }
        } else {
            throw new Error(data.message);
        }
    })
    .catch(error => {
        hideLoader();
        showToast('Error al enviar respuestas: ' + error.message, 'error');
        console.error('Error:', error);
    });
}
// modal para crear una nueva encuesta
let questionCount = 0;

function addQuestion() {
    questionCount++;
    const container = document.getElementById('questionsContainer');
    const qId = `question-${questionCount}`;
    const html = `
        <div class="card mb-3" id="${qId}">
            <div class="card-body">
                <div class="mb-2">
                    <label class="form-label">Texto de la pregunta</label>
                    <input type="text" class="form-control" name="pregunta_texto_${questionCount}" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Tipo de respuesta</label>
                    <select class="form-select" name="pregunta_tipo_${questionCount}" onchange="renderOptions(this, ${questionCount})" required>
                        <option value="">Selecciona...</option>
                        <option value="escala_5">Escala 1-5</option>
                        <option value="escala_10">Escala 1-10</option>
                        <option value="si_no">Sí/No</option>
                        <option value="texto_libre">Texto libre</option>
                        <option value="opcion_multiple">Opción múltiple</option>
                    </select>
                </div>
                <div id="options_${questionCount}"></div>
                <button type="button" class="btn btn-danger btn-sm mt-2" onclick="removeQuestion('${qId}')">Eliminar pregunta</button>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
}

function removeQuestion(qId) {
    document.getElementById(qId).remove();
}

function renderOptions(select, idx) {
    const value = select.value;
    const optionsDiv = document.getElementById(`options_${idx}`);
    let html = '';
    if (value === 'escala_5') {
        html = '<div class="mb-2">Escala de 1 a 5 (se genera automáticamente)</div>';
    } else if (value === 'escala_10') {
        html = '<div class="mb-2">Escala de 1 a 10 (se genera automáticamente)</div>';
    } else if (value === 'si_no') {
        html = '<div class="mb-2">Opciones: Sí / No (se genera automáticamente)</div>';
    } else if (value === 'opcion_multiple') {
        html = `
            <div class="mb-2">
                <label>Opciones (separadas por coma)</label>
                <input type="text" class="form-control" name="pregunta_opciones_${idx}" placeholder="Ejemplo: Opción 1, Opción 2, Opción 3" required>
            </div>
        `;
    }
    optionsDiv.innerHTML = html;
}
// Función para guardar una nueva encuesta
document.getElementById('createSurveyForm').addEventListener('submit', function(e) {
    e.preventDefault();

    // Obtener datos de la encuesta
    const nombre = document.getElementById('surveyName').value;
    const descripcion = document.getElementById('surveyDesc').value;
    const tipo = document.getElementById('surveyType').value;

    // Obtener preguntas
    const preguntas = [];
    const container = document.getElementById('questionsContainer');
    const cards = container.querySelectorAll('.card');
    cards.forEach(card => {
        const textoInput = card.querySelector('input[name^="pregunta_texto_"]');
        const tipoSelect = card.querySelector('select[name^="pregunta_tipo_"]');
        if (!textoInput || !tipoSelect) return; // Salta si no encuentra los campos

        const texto = textoInput.value;
        const tipoRespuesta = tipoSelect.value;
        let opciones = [];

        if (tipoRespuesta === 'opcion_multiple') {
            const opcionesInput = card.querySelector('input[name^="pregunta_opciones_"]');
            const opcionesStr = opcionesInput ? opcionesInput.value : '';
            opciones = opcionesStr.split(',').map(o => o.trim()).filter(o => o.length > 0);
        } else if (tipoRespuesta === 'escala_5') {
            opciones = ['1', '2', '3', '4', '5'];
        } else if (tipoRespuesta === 'escala_10') {
            opciones = Array.from({length: 10}, (_, i) => (i+1).toString());
        } else if (tipoRespuesta === 'si_no') {
            opciones = ['Sí', 'No'];
        }

        preguntas.push({
            texto,
            tipo_respuesta: tipoRespuesta,
            opciones
        });
    });

    // Construir payload
    const payload = {
        nombre,
        descripcion,
        tipo,
        preguntas
    };

    showLoader();

    fetch('?c=CEncuesta/insert', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(payload)
    })
    .then(response => response.json())
    .then(data => {
        hideLoader();
        if (data.success) {
            showToast('Encuesta creada correctamente');
            document.getElementById('createSurveyForm').reset();
            document.getElementById('questionsContainer').innerHTML = '';
            questionCount = 0;
            new bootstrap.Modal(document.getElementById('createSurveyModal')).hide();
            loadSurveys();
        } else {
            showToast('Error al crear la encuesta', 'error');
        }
    })
    .catch(error => {
        hideLoader();
        showToast('Error en el servidor', 'error');
        console.error(error);
    });
});
// Inicializar la aplicación cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', initApp);