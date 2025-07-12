// Datos de las encuestas
const surveys = {
    sus: {
        title: "Usabilidad E-commerce (SUS)",
        description: "Por favor, califique las siguientes afirmaciones sobre su experiencia en nuestro sitio web. Utilice la escala de 1 (Totalmente en desacuerdo) a 5 (Totalmente de acuerdo).",
        questions: [
            {
                id: 1,
                text: "Creo que me gustaría usar este sitio web frecuentemente",
                required: true,
                type: "scale",
                options: [
                    "Totalmente en desacuerdo",
                    "En desacuerdo",
                    "Neutral",
                    "De acuerdo",
                    "Totalmente de acuerdo"
                ]
            },
            {
                id: 2,
                text: "Encontré el sitio innecesariamente complejo",
                required: true,
                type: "scale",
                options: [
                    "Totalmente en desacuerdo",
                    "En desacuerdo",
                    "Neutral",
                    "De acuerdo",
                    "Totalmente de acuerdo"
                ]
            },
            {
                id: 3,
                text: "Me pareció fácil de usar",
                required: true,
                type: "scale",
                options: [
                    "Totalmente en desacuerdo",
                    "En desacuerdo",
                    "Neutral",
                    "De acuerdo",
                    "Totalmente de acuerdo"
                ]
            },
            {
                id: 4,
                text: "Comentarios adicionales",
                required: false,
                type: "text",
                placeholder: "¿Tiene alguna sugerencia para mejorar nuestro sitio web?"
            }
        ]
    },
    nps: {
        title: "Lealtad de Clientes (NPS)",
        description: "En una escala de 0 a 10, ¿qué tan probable es que recomiendes nuestro sitio web a un amigo o colega?",
        questions: [
            {
                id: 1,
                text: "¿Qué tan probable es que recomiendes nuestro sitio a un amigo o colega?",
                required: true,
                type: "nps",
                options: Array.from({length: 11}, (_, i) => i.toString())
            },
            {
                id: 2,
                text: "¿Por qué le diste esa puntuación?",
                required: false,
                type: "text",
                placeholder: "Explica tu respuesta..."
            }
        ]
    },
    csat: {
        title: "Satisfacción Post-Compra (CSAT)",
        description: "Por favor, califique su experiencia después de realizar una compra en nuestro sitio.",
        questions: [
            {
                id: 1,
                text: "¿Qué tan satisfecho estás con tu experiencia de compra?",
                required: true,
                type: "scale",
                options: [
                    "Muy insatisfecho",
                    "Insatisfecho",
                    "Neutral",
                    "Satisfecho",
                    "Muy satisfecho"
                ]
            },
            {
                id: 2,
                text: "¿Qué fue lo que más te gustó de la experiencia?",
                required: false,
                type: "text",
                placeholder: "Describe lo que más te gustó..."
            },
            {
                id: 3,
                text: "¿Qué mejorarías de la experiencia?",
                required: false,
                type: "text",
                placeholder: "Describe lo que mejorarías..."
            }
        ]
    }
};

// Abrir modal con la encuesta correspondiente
document.addEventListener('DOMContentLoaded', function() {
    const surveyModal = document.getElementById('surveyModal');
    
    surveyModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const surveyType = button.getAttribute('data-survey');
        const survey = surveys[surveyType];
        
        if (survey) {
            renderSurveyModal(survey);
        }
    });
});

// Renderizar la encuesta en el modal
function renderSurveyModal(survey) {
    const modalContent = document.getElementById('modalContent');
    let questionsHTML = '';
    
    // Generar HTML para cada pregunta
    survey.questions.forEach((question, index) => {
        questionsHTML += `
            <div class="question-item animate-fade-in" style="animation-delay: ${index * 0.1}s">
                <div class="d-flex justify-content-between mb-2">
                    <h6>${index + 1}. ${question.text}</h6>
                    ${question.required ? '<small class="text-danger">* Requerido</small>' : ''}
                </div>
                ${renderQuestionInput(question)}
            </div>
        `;
    });
    
    // Construir el contenido completo del modal
    modalContent.innerHTML = `
        <div class="modal-header">
            <h5 class="modal-title">${survey.title}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p class="text-muted">${survey.description}</p>
            <form id="surveyForm">
                ${questionsHTML}
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" onclick="submitSurvey()">Enviar Respuesta</button>
        </div>
    `;
}

// Renderizar el input de cada pregunta
function renderQuestionInput(question) {
    if (question.type === 'text') {
        return `
            <textarea class="form-control" rows="3" placeholder="${question.placeholder || 'Escribe tu respuesta aquí...'}" 
                ${question.required ? 'required' : ''}></textarea>
        `;
    }
    
    if (question.type === 'nps') {
        return `
            <div class="d-flex justify-content-between mb-3">
                <small>0 - Poco probable</small>
                <small>10 - Muy probable</small>
            </div>
            <div class="nps-scale">
                ${question.options.map(option => `
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="nps" id="nps${option}" value="${option}" required>
                        <label class="form-check-label" for="nps${option}">${option}</label>
                    </div>
                `).join('')}
            </div>
        `;
    }
    
    return `
        <div class="response-options">
            ${question.options.map((option, idx) => `
                <div class="response-option" onclick="selectOption(this)">
                    <input type="radio" class="form-check-input" 
                        name="question${question.id}" 
                        id="q${question.id}o${idx}" 
                        value="${option}"
                        ${question.required ? 'required' : ''}>
                    <label class="form-check-label ms-2" for="q${question.id}o${idx}">${option}</label>
                </div>
            `).join('')}
        </div>
    `;
}

// Seleccionar una opción de respuesta
function selectOption(element) {
    const container = element.closest('.response-options');
    if (container) {
        container.querySelectorAll('.response-option').forEach(opt => {
            opt.classList.remove('selected');
        });
    }
    element.classList.add('selected');
    const radio = element.querySelector('input[type="radio"]');
    if (radio) {
        radio.checked = true;
    }
}

// Enviar la encuesta
function submitSurvey() {
    const form = document.getElementById('surveyForm');
    if (form.checkValidity()) {
        // Aquí iría la lógica para enviar los datos al servidor
        alert('¡Gracias por completar la encuesta! Tus respuestas han sido registradas.');
        
        // Cerrar el modal después de 1 segundo
        setTimeout(() => {
            const modal = bootstrap.Modal.getInstance(document.getElementById('surveyModal'));
            modal.hide();
        }, 1000);
    } else {
        form.reportValidity();
    }
}

// Añadir animación a las tarjetas al cargar
document.querySelectorAll('.survey-card').forEach((card, index) => {
    card.style.animation = `fadeIn 0.5s ease-out ${index * 0.1}s forwards`;
    card.style.opacity = 0;
});