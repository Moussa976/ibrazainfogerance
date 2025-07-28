function animateValue(element, start, end, duration) {
	let startTimestamp = null;
	const step = (timestamp) => {
		if (!startTimestamp) startTimestamp = timestamp;
		const progress = Math.min((timestamp - startTimestamp) / duration, 1);
		element.innerHTML = Math.floor(progress * (end - start) + start);
		if (progress < 1) {
			window.requestAnimationFrame(step);
		}
	};
	window.requestAnimationFrame(step);
}

const section = document.getElementById('statistiques');
if (section) {
	const observerStats = new IntersectionObserver((entries) => {
		entries.forEach(entry => {
			if (entry.isIntersecting) {
				const counters = document.querySelectorAll('[id^="stat-"]');
				counters.forEach(counter => {
					const target = parseInt(counter.dataset.target);
					if (!isNaN(target)) {
						animateValue(counter, 0, target, 2000);
					}
				});
				observerStats.unobserve(entry.target);
			}
		});
	}, { threshold: 0.5 });

	observerStats.observe(section);
}
