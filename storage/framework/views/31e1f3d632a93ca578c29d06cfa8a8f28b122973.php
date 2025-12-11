<?php
    $motelsToShow = collect($spotlightMotels ?? [])->take(18);
?>
<!-- Featured Motels / Our Exquisite Rooms Section -->
<?php if($motelsToShow->isNotEmpty()): ?>
    <section class="exquisite-rooms-section">
        <div class="ers-container">
            <!-- Section Header -->
            <div class="ers-header" data-aos="fade-up">
                <span class="ers-label">Featured Stays</span>
                <h2 class="ers-title"><?php echo e(__('website.home_exquisite.title')); ?></h2>
                <p class="ers-subtitle"><?php echo e(__('website.home_exquisite.subtitle')); ?></p>
            </div>

            <!-- Motels Grid -->
            <div class="motels-grid">
                <?php $__currentLoopData = $motelsToShow; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $motel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.motel-card','data' => ['motel' => $motel,'dataAos' => 'fade-up','dataAosDelay' => $index * 100]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('motel-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['motel' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($motel),'data-aos' => 'fade-up','data-aos-delay' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($index * 100)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap');

.exquisite-rooms-section {
    padding: 3rem 1rem 4rem;
    background: #ffffff;
    position: relative;
    overflow: hidden;
    width: 100vw;
    margin-left: calc(50% - 50vw);
    margin-right: calc(50% - 50vw);
    font-family: 'DM Sans', -apple-system, BlinkMacSystemFont, sans-serif;
}

.ers-container {
    width: 100%;
    max-width: 100%;
    margin: 0 auto;
    padding: 0 1rem;
}

.ers-header {
    text-align: center;
    margin-bottom: 3rem;
}

.ers-label {
    display: inline-block;
    font-size: 0.9rem;
    font-weight: 600;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: #0ea5e9;
    margin-bottom: 1.25rem;
}

.ers-title {
    font-size: clamp(2.5rem, 5vw, 3.5rem);
    font-weight: 700;
    color: #0f172a;
    letter-spacing: -0.02em;
    line-height: 1.2;
    margin: 0 0 1.25rem;
}

.ers-subtitle {
    font-size: 1.25rem;
    color: #475569;
    line-height: 1.7;
    max-width: 600px;
    margin: 0 auto;
}

.motels-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 2.5rem;
}

@media (max-width: 1100px) {
    .exquisite-rooms-section {
        padding: 5rem 0.75rem;
    }

    .motels-grid {
        gap: 1.5rem;
    }
}

@media (max-width: 900px) {
    .motels-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .ers-header {
        margin-bottom: 3.5rem;
    }
}

@media (max-width: 768px) {
    .exquisite-rooms-section {
        padding: 4rem 0.5rem;
    }

    .ers-container {
        padding: 0 0.5rem;
    }

    .motels-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
}

@media (max-width: 480px) {
    .ers-title {
        font-size: 2rem;
    }

    .ers-subtitle {
        font-size: 1.1rem;
    }
}
</style>
<?php /**PATH C:\Users\iuser\Desktop\PROJECTS\BNB PROJECT\bnbbackendlaravel\resources\views/websitepages/homepage/exquisite-rooms.blade.php ENDPATH**/ ?>