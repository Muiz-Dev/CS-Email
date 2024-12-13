function emailApp() {
  return {
    to: '',
    subject: '',
    recipientName: '',
    content: '',
    selectedTemplate: '',
    attachment: null,
    sending: false,

    init() {
      tinymce.init({
        selector: '#content',
        plugins: 'link image code',
        toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | link image | code',
        height: 300
      });
    },

    loadTemplate() {
      if (this.selectedTemplate) {
        fetch(`templates/${this.selectedTemplate}.html`)
          .then(response => response.text())
          .then(template => {
            // Extract the content section from the template
            const contentSection = template.match(/<td style="padding: 30px; color: #d1d1d1; text-align: left;">([\s\S]*?)<\/td>/)[1];
            tinymce.get('content').setContent(contentSection);
          })
          .catch(error => {
            console.error('Error loading template:', error);
            Swal.fire('Error', 'Failed to load template', 'error');
          });
      }
    },

    handleFileUpload(event) {
      this.attachment = event.target.files[0];
    },

    sendEmail() {
      this.sending = true;
      const formData = new FormData();
      formData.append('to', this.to);
      formData.append('subject', this.subject);
      formData.append('recipientName', this.recipientName);
      formData.append('content', tinymce.get('content').getContent());
      formData.append('template', this.selectedTemplate);
      if (this.attachment) {
        formData.append('attachment', this.attachment);
      }

      fetch('send.php', {
          method: 'POST',
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          this.sending = false;
          if (data.success) {
            Swal.fire('Success', 'Email sent successfully', 'success');
            this.resetForm();
          } else {
            Swal.fire('Error', data.message || 'Failed to send email', 'error');
          }
        })
        .catch(error => {
          this.sending = false;
          console.error('Error:', error);
          Swal.fire('Error', 'An unexpected error occurred', 'error');
        });
    },

    resetForm() {
      this.to = '';
      this.subject = '';
      this.recipientName = '';
      this.selectedTemplate = '';
      tinymce.get('content').setContent('');
      this.attachment = null;
      document.getElementById('attachment').value = '';
    }
  };
}