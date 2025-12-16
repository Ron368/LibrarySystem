document.addEventListener('DOMContentLoaded', () => {
  const isbnInput = document.getElementById('IBSN');
  const fetchButton = document.getElementById('openLibraryFetch');
  const statusEl = document.getElementById('openLibraryStatus');

  const updateStatus = (message, isError = false) => {
    if (!statusEl) return;
    statusEl.textContent = message;
    statusEl.classList.toggle('text-danger', !!isError);
    statusEl.classList.toggle('text-muted', !isError);
  };

  const normalizeDate = (rawDate) => {
    if (!rawDate) return '';
    const parsed = new Date(rawDate);
    if (!Number.isNaN(parsed.getTime())) {
      const yyyy = parsed.getFullYear();
      const mm = String(parsed.getMonth() + 1).padStart(2, '0');
      const dd = String(parsed.getDate()).padStart(2, '0');
      return `${yyyy}-${mm}-${dd}`;
    }
    const yearMatch = rawDate.match(/(\d{4})/);
    if (yearMatch) {
      return `${yearMatch[1]}-01-01`;
    }
    return '';
  };

  const setValueIfEmpty = (id, value) => {
    const el = document.getElementById(id);
    if (el && value && !el.value) {
      el.value = value;
    }
  };

  const applyBookData = (bookData) => {
    const authors = Array.isArray(bookData.authors) ? bookData.authors : [];
    const publishers = Array.isArray(bookData.publishers) ? bookData.publishers : [];
    const description = typeof bookData.description === 'string'
      ? bookData.description
      : (bookData.description && bookData.description.value) || '';

    setValueIfEmpty('BookTitle', bookData.title || '');
    setValueIfEmpty('Author', authors[0] && authors[0].name ? authors[0].name : '');
    setValueIfEmpty('BookPublisher', publishers[0] && publishers[0].name ? publishers[0].name : '');
    setValueIfEmpty('BookDesc', description || bookData.subtitle || '');

    const normalizedDate = normalizeDate(bookData.publish_date || '');
    if (normalizedDate) {
      setValueIfEmpty('PublishDate', normalizedDate);
    }
  };

  const fetchFromOpenLibrary = async () => {
    if (!isbnInput) return;
    const isbn = isbnInput.value.trim();
    if (!isbn) {
      updateStatus('Enter an ISBN to fetch details.', true);
      return;
    }

    try {
      if (fetchButton) {
        fetchButton.setAttribute('disabled', 'disabled');
      }
      updateStatus('Fetching details from OpenLibrary...');
      const response = await fetch(`https://openlibrary.org/api/books?bibkeys=ISBN:${encodeURIComponent(isbn)}&format=json&jscmd=data`);
      if (!response.ok) {
        throw new Error('Request failed');
      }
      const payload = await response.json();
      const key = `ISBN:${isbn}`;
      if (!payload[key]) {
        updateStatus('No OpenLibrary data found for that ISBN.', true);
        return;
      }

      applyBookData(payload[key]);
      updateStatus('Details loaded from OpenLibrary.');
    } catch (error) {
      updateStatus('Unable to reach OpenLibrary. Please fill the fields manually.', true);
    } finally {
      if (fetchButton) {
        fetchButton.removeAttribute('disabled');
      }
    }
  };

  if (fetchButton) {
    fetchButton.addEventListener('click', (event) => {
      event.preventDefault();
      fetchFromOpenLibrary();
    });
  }
});
